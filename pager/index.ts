// ページネーション用logic
// export default new main()

class main {
  _selectPage: number
  _totalPage: number
  _totalItem: number
  _displayedItems: number
  _offset: number
  constructor (totalItem: number, displayItem: number){
    this._selectPage = 1
    this._totalPage = 1
    this._totalItem = totalItem // アイテムの総数
    this._displayedItems = displayItem // 表示アイテム数
    this._offset = 0

    this.totalPage()
  }

  setTotalItem(total: number) {
    this._totalItem = total
    this.totalPage()
    this._selectPage = 1
    return this
  }

  totalPage() {
    const isTotal = this._totalItem > this._displayedItems
    if (isTotal) this._totalPage = Math.ceil(this._totalItem / this._displayedItems)
    if (!isTotal) this._totalPage = 1
    this.offset()
  }

  offset() {
    this._offset = this._displayedItems * (this._selectPage - 1)
  }

  getTotalPage() {
    return this._totalPage
  }

  setDisplayItem(displayNum: number) {
    this._displayedItems = displayNum
    return this
  }

  getCurrent() {
    return this._selectPage
  }

  getAarray(arr: []) {
    return arr.slice(this._offset,this._offset + this._displayedItems)
  }

  isCurrent(val: number) {
    if (val === this._selectPage) return true
      return false
  }

  getOffset() {
    return this._offset
  }

  setPage(num: number) {
    // 選択したpageをセット
    this._selectPage = num
    this.offset()
    return this
  }

  prev() {
    // 前のpageをセットする
    let page = this._selectPage - 1
    page = this.prevNum(page)
    this.setPage(page)
  }

  next() {
    // 次のpageをセットする
    let page = this._selectPage + 1
    page = this.nextNum(page)
    this.setPage(page)
  }

  prevNum(val: number) {
    // 値を選択できる範囲に収めてくれる
    if (this.isPrev(val)) return val
    return 1
  }

  nextNum(val: number) {
    // 値を選択できる範囲に収めてくれる
    if (this.isNext(val)) return val
    return this._totalPage
  }

  isPrev(num: number) {
    // 前のpageがあるか判定
    if (num - 1 > 0) return true
      return false
  }

  isNext(num: number) {
    // 次のpageがあるか判定
    if (num + 1 <= this._totalPage) return true
      return false
  }

}

