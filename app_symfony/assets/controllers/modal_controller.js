// controllers/modal_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['modal', 'content'];

  open() {
    this.modalTarget.classList.remove('opacity-0', 'pointer-events-none', 'hidden');
    this.contentTarget.classList.remove('scale-95');
    this.contentTarget.classList.add('scale-100');
  }

  close() {
    this.modalTarget.classList.add('opacity-0', 'pointer-events-none');
    setTimeout(() => {
      this.modalTarget.classList.add('hidden');
      this.contentTarget.classList.remove('scale-100');
      this.contentTarget.classList.add('scale-95');
    }, 300); // durée de la transition
  }
}
