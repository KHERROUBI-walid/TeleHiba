// controllers/mobile_menu_controller.js
import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['menu', 'toggle']

    connect() {
      this.handleOutsideClick = this.handleOutsideClick.bind(this)
      document.addEventListener('click', this.handleOutsideClick)
    }


  disconnect() {
    document.removeEventListener('click', this.handleOutsideClick)
  }

  toggle(event) {
    event.stopPropagation()
    const isOpen = this.menuTarget.classList.contains('translate-x-0')
    this.menuTarget.classList.toggle('translate-x-0', !isOpen)
    this.menuTarget.classList.toggle('-translate-x-full', isOpen)
    this.toggleTarget.setAttribute('aria-expanded', String(!isOpen))
  }

  handleOutsideClick(event) {
    if (
      this.hasMenuTarget &&
      !this.menuTarget.contains(event.target) &&
      !this.toggleTarget.contains(event.target)
    ) {
      this.menuTarget.classList.remove('translate-x-0')
      this.menuTarget.classList.add('-translate-x-full')
      this.toggleTarget.setAttribute('aria-expanded', 'false')
    }
  }
}
