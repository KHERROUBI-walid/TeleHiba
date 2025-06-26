// assets/controllers/password_visibility_controller.js
import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['input', 'toggle']

  connect() {
    this.updateIcon()
  }

  toggleVisibility() {
    const type = this.inputTarget.type === 'password' ? 'text' : 'password'
    this.inputTarget.type = type
    this.updateIcon()
  }

  updateIcon() {
    const isVisible = this.inputTarget.type === 'text'
    this.toggleTarget.textContent = isVisible ? '🙈' : '👁️'
  }
}
