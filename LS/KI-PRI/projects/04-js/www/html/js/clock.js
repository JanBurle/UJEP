function makeClock(clockSize) {
  // SVG namespace
  let svgNS = 'http://www.w3.org/2000/svg'
  // append SVG elem
  let addElem = (parent, tag) => parent.appendChild(document.createElementNS(svgNS, tag))

  // assign attrs to elem
  let setAttrs = (elem, attrs) => {
    for (let attr in attrs) elem.setAttribute(attr, attrs[attr])
  }

  let makeMovable = (elem) => {
    elem.classList.add('movable')

    // get/set elem attributes
    let getAttr = (attr) => elem.getAttribute(attr)
    let setAttr = (attr, val) => elem.setAttribute(attr, val)

    let getX = () => parseFloat(getAttr('cx') || 0)
    let getY = () => parseFloat(getAttr('cy') || 0)

    let setX = (x) => setAttr('cx', x)
    let setY = (y) => setAttr('cy', y)

    // event handlers
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

  let divTime = document.getElementById('time')
  let clock = document.getElementById('clock')

  let makeLine = (x1, y1, x2, y2) => {
    let line = addElem(clock, 'line')
    setAttrs(line, {x1, y1, x2, y2}) // {x1, y1, x2, y2}: JS shorthand!!!
    return line
  }

  let rotate = (line, deg) => {
    // +180 degrees - otherwise would the clock be upside down
    line.setAttribute('transform', `rotate(${deg + 180}, 0, 0)`)
  }

  let makeMinMark = (deg) => {
    let mark = makeLine(0, clockSize, 0, (clockSize * 30) / 31)
    rotate(mark, deg)
    return mark
  }

  let makeHourMark = (deg) => {
    let mark = makeLine(0, clockSize, 0, (clockSize * 9) / 10)
    rotate(mark, deg)
    return mark
  }

  for (let i = 0; i < 60; ++i) makeMinMark(i * 6)
  for (let i = 0; i < 12; ++i) makeHourMark(i * 30)

  let makeHand = (size, width) => {
    let hand = addElem(clock, 'line')
    setAttrs(hand, {
      'stroke-width': width,
      x1: 0,
      y1: -size / 5,
      x2: 0,
      y2: size,
    })
    return hand
  }

  let secHand = makeHand(130, 3)
  let minHand = makeHand(120, 4)
  let hourHand = makeHand(100, 6)
  setAttrs(secHand, {
    stroke: 'red',
  })

  let hub = addElem(clock, 'circle')
  setAttrs(hub, {
    r: 10,
    fill: 'cyan',
  })

  makeMovable(hub)

  let tick = () => {
    let now = new Date()
    divTime.textContent = now.toLocaleTimeString()

    let sec = now.getSeconds()
    let min = now.getMinutes()
    let hour = now.getHours()

    rotate(secHand, sec * 6)
    rotate(minHand, (min + sec / 60) * 6)
    rotate(hourHand, (hour + min / 60 + sec / 3600) * 30)
  }

  tick()
  setInterval(tick, 1000)
}

// document.addEventListener('DOMContentLoaded', () => makeClock(140))
