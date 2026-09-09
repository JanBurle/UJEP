type num = number
type str = string

// @ts-ignore
function makeClock(clockSize: num) {
  // SVG namespace
  let svgNS = 'http://www.w3.org/2000/svg'
  // append SVG elem
  let addElem = (parent: Element, tag: str) =>
    parent.appendChild(document.createElementNS(svgNS, tag))

  // assign attrs to elem
  let setAttrs = (elem: Element, attrs: {[key: string]: string}) => {
    for (let attr in attrs) elem.setAttribute(attr, attrs[attr])
  }

  let makeMovable = (elem: SVGElement) => {
    elem.classList.add('movable')

    // get/set elem attributes
    let getAttr = (attr: str) => elem.getAttribute(attr)
    let setAttr = (attr: str, val: str) => elem.setAttribute(attr, val)
    // @ts-ignore
    let getX = () => parseFloat(getAttr('cx') || 0)
    // @ts-ignore
    let getY = () => parseFloat(getAttr('cy') || 0)

    let setX = (x: num) => setAttr('cx', x.toString())
    let setY = (y: num) => setAttr('cy', y.toString())

    // event handlers
    elem.onpointerdown = (evt) => {
      // @ts-ignore
      elem.dX = getX() - evt.clientX
      // @ts-ignore
      elem.dY = getY() - evt.clientY

      elem.onpointermove = (evt) => {
        // @ts-ignore
        setX(evt.clientX + elem.dX)
        // @ts-ignore
        setY(evt.clientY + elem.dY)
      }

      elem.setPointerCapture(evt.pointerId)
    }

    elem.onpointerup = (evt) => {
      elem.onpointermove = null // !!!
      elem.releasePointerCapture(evt.pointerId)
    }
  }

  let divTime = document.getElementById('time')!
  let clock = document.getElementById('clock')!

  let makeLine = (x1: num, y1: num, x2: num, y2: num) => {
    let line = addElem(clock, 'line')
    // @ts-ignore
    setAttrs(line, {x1, y1, x2, y2}) // {x1, y1, x2, y2}: JS shorthand!!!
    return line
  }

  let rotate = (line: Element, deg: num) => {
    // +180 degrees - otherwise would the clock be upside down
    line.setAttribute('transform', `rotate(${deg + 180}, 0, 0)`)
  }

  let makeMinMark = (deg: num) => {
    let mark = makeLine(0, clockSize, 0, (clockSize * 30) / 31)
    rotate(mark, deg)
    return mark
  }

  let makeHourMark = (deg: num) => {
    let mark = makeLine(0, clockSize, 0, (clockSize * 9) / 10)
    rotate(mark, deg)
    return mark
  }

  for (let i = 0; i < 60; ++i) makeMinMark(i * 6)
  for (let i = 0; i < 12; ++i) makeHourMark(i * 30)

  let makeHand = (size: num, width: num) => {
    let hand = addElem(clock, 'line')
    setAttrs(hand, {
      // @ts-ignore
      'stroke-width': width,
      // @ts-ignore
      x1: 0,
      // @ts-ignore
      y1: -size / 5,
      // @ts-ignore
      x2: 0,
      // @ts-ignore
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
    // @ts-ignore
    r: 10,
    fill: 'cyan',
  })

  makeMovable(hub as SVGElement)

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
