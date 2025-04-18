let svgNS = 'http://www.w3.org/2000/svg'
let addElem = (parent, tag) => parent.appendChild(document.createElementNS(svgNS, tag))

/**
 * Sets attributes on the given element based on the provided attribute object.
 *
 * @param {Element} elem - The element on which attributes will be set.
 * @param {Object} attrs - The object containing attribute key-value pairs.
 */
let setAttrs = (elem, attrs) => {
  for (let attr in attrs) elem.setAttribute(attr, attrs[attr])
}

let makeCircleMovable = (elem) => {
  elem.classList.add('movable')

  let getAttr = (attr) => elem.getAttribute(attr)
  let setAttr = (attr, val) => elem.setAttribute(attr, val)

  let getX = () => parseFloat(getAttr('cx') || 0)
  let getY = () => parseFloat(getAttr('cy') || 0)

  let setX = (x) => setAttr('cx', x)
  let setY = (y) => setAttr('cy', y)

  // mousedown, mousemove, mouseup, mouseleave: deprecated
  elem.onpointerdown = (evt) => {
    elem.dX = getX() - evt.clientX
    elem.dY = getY() - evt.clientY

    elem.onpointermove = (evt) => {
      setX(evt.clientX + elem.dX)
      setY(evt.clientY + elem.dY)
    }

    elem.setPointerCapture(evt.pointerId)
  }

  elem.onpointerup = (evt) => {
    elem.onpointermove = null // !!!
    elem.releasePointerCapture(evt.pointerId)
  }
}

let makeClock = (clockSize) => {
  let divTime = document.getElementById('time')
  let clock = document.getElementById('clock')

  let makeLine = (x1, y1, x2, y2) => {
    let line = addElem(clock, 'line')
    // line.setAttribute('x1', x1)
    // line.setAttribute('y1', y1)
    // line.setAttribute('x2', x2)
    // line.setAttribute('y2', y2)
    // setAttrs(line, {
    //   x1: x1,
    //   y1: y1,
    //   x2: x2,
    //   y2: y2,
    // })
    setAttrs(line, {x1, y1, x2, y2}) // !!!
    return line
  }

  let rotate = (line, deg) => {
    // +180 - so the clock is not upside down
    line.setAttribute('transform', `rotate(${deg + 180}, 0, 0)`)
  }

  let makeHourMark = (deg) => {
    let mark = makeLine(0, clockSize, 0, (clockSize * 9) / 10)
    rotate(mark, deg)
    return mark
  }

  for (let i = 0; i < 12; ++i) makeHourMark(i * 30)

  let makeHand = (size, width) => {
    let hand = addElem(clock, 'line')

    // hand.setAttribute('stroke-width', width)
    // hand.setAttribute('x1', '0')
    // hand.setAttribute('y1', -size / 5)
    // hand.setAttribute('x2', '0')
    // hand.setAttribute('y2', size)
    setAttrs(hand, {
      'stroke-width': width,
      x1: 0,
      y1: -size / 5,
      x2: 0,
      y2: size,
    })
    return hand
  }

  let handSec = makeHand(130, 3)
  let handMin = makeHand(120, 4)
  let handHour = makeHand(100, 6)

  let hub = addElem(clock, 'circle')
  //   hub.setAttribute('cx', '0')
  //   hub.setAttribute('cy', '0')
  //   hub.setAttribute('r', '10')
  //   hub.setAttribute('fill', 'cyan')
  setAttrs(hub, {
    r: 10,
    fill: 'cyan',
  })
  makeCircleMovable(hub)

  let tick = () => {
    let now = new Date()
    divTime.textContent = now.toLocaleTimeString()

    let sec = now.getSeconds()
    rotate(handSec, sec * 6)

    let min = now.getMinutes()
    rotate(handMin, (min + sec / 60) * 6)

    let hour = now.getHours()
    rotate(handHour, (hour + min / 60 + sec / 3600) * 30)
  }

  tick()
  setInterval(tick, 1000)
}
