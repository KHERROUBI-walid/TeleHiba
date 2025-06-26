import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['menu', 'button']

  connect() {
    this.isOpen = false
    this.outsideClickListener = this.handleOutsideClick.bind(this)
  }

  toggle() {
    this.isOpen = !this.isOpen
    this.menuTarget.classList.toggle('hidden', !this.isOpen)
    this.buttonTarget.setAttribute('aria-expanded', this.isOpen.toString())

    if (this.isOpen) {
      document.addEventListener('click', this.outsideClickListener)
    } else {
      document.removeEventListener('click', this.outsideClickListener)
    }
  }

  handleOutsideClick(event) {
    if (!this.element.contains(event.target)) {
      this.isOpen = false
      this.menuTarget.classList.add('hidden')
      this.buttonTarget.setAttribute('aria-expanded', 'false')
      document.removeEventListener('click', this.outsideClickListener)
    }
  }
}
