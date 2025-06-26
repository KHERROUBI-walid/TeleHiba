// assets/controllers/registration_controller.js
import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = [
    "step1", "step2", "dot1", "dot2", "typeSelect",
    "adresse", "complAdresse", "codePostal", "ville", "pays"
  ];

  connect() {
    this.requiredStep1Selectors = [
      '#registration_form_email',
      '#registration_form_plainPassword',
      '#registration_form_typeUtilisateur',
      '#registration_form_civilite',
      '#registration_form_nom',
      '#registration_form_prenom',
      '#registration_form_telephone'
    ];

    this.setProgress(1);

    // Nettoyage bordures rouges au focus
    document.querySelectorAll('input, select').forEach(input => {
      input.addEventListener('input', () => {
        input.classList.remove('border', 'border-red-600');
      });
    });
  }

  nextStep(event) {
    event.preventDefault();
    if (!this.validateStep1()) return;

    const userType = this.typeSelectTarget.value;
    if (!userType) {
      this.typeSelectTarget.classList.add('border', 'border-red-600');
      return;
    }
    this.typeSelectTarget.classList.remove('border', 'border-red-600');

    this.configureStep2Fields(userType);

    this.step1Target.classList.add("hidden");
    this.step2Target.classList.remove("hidden");
    this.setProgress(2);
  }

  prevStep(event) {
    event.preventDefault();
    this.step2Target.classList.add("hidden");
    this.step1Target.classList.remove("hidden");
    this.setProgress(1);

    this.requiredStep1Selectors.forEach(selector => {
      const field = document.querySelector(selector);
      if (field) field.classList.remove('border', 'border-red-600');
    });
  }

  validateStep1() {
    let valid = true;
    this.requiredStep1Selectors.forEach(selector => {
      const field = document.querySelector(selector);
      if (!field) return;
      if (!field.value.trim()) {
        field.classList.add('border', 'border-red-600');
        valid = false;
      } else {
        field.classList.remove('border', 'border-red-600');
      }
    });
    return valid;
  }

  setProgress(step) {
    if (step === 1) {
      this.dot1Target.classList.add('opacity-100');
      this.dot1Target.classList.remove('opacity-50', 'animate-pulse');

      this.dot2Target.classList.add('opacity-50', 'animate-pulse');
      this.dot2Target.classList.remove('opacity-100');
    } else if (step === 2) {
      this.dot1Target.classList.add('opacity-100');
      this.dot1Target.classList.remove('opacity-50', 'animate-pulse');

      this.dot2Target.classList.add('opacity-100');
      this.dot2Target.classList.remove('opacity-50', 'animate-pulse');
    }
  }

  configureStep2Fields(userType) {
    if (userType === 'famille' || userType === 'vendeur') {
      this.adresseTarget.parentElement.classList.remove('hidden');
      this.complAdresseTarget.parentElement.classList.remove('hidden');
      this.codePostalTarget.parentElement.classList.remove('hidden');
      this.villeTarget.parentElement.classList.remove('hidden');
      this.paysTarget.parentElement.classList.remove('hidden');

      this.adresseTarget.required = true;
      this.codePostalTarget.required = true;
      this.villeTarget.required = true;
      this.paysTarget.required = true;
      this.complAdresseTarget.required = false;
    } else if (userType === 'donateur') {
      this.adresseTarget.parentElement.classList.add('hidden');
      this.complAdresseTarget.parentElement.classList.add('hidden');
      this.codePostalTarget.parentElement.classList.add('hidden');
      this.villeTarget.parentElement.classList.remove('hidden');
      this.paysTarget.parentElement.classList.remove('hidden');

      this.adresseTarget.required = false;
      this.complAdresseTarget.required = false;
      this.codePostalTarget.required = false;
      this.villeTarget.required = false;
      this.paysTarget.required = false;
    }
  }
}
