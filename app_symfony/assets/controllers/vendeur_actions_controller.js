import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static values = {
    url: String
  }

  connect() {
    this.element.addEventListener('click', () => {
      if (this.hasUrlValue) {
        window.location.href = this.urlValue
      }
    })
  }
}
