// controllers/language_switcher_controller.js
import { Controller } from '@hotwired/stimulus'
import { visit } from '@hotwired/turbo'

export default class extends Controller {
  submit(event) {
    const selectedLocale = event.target.value
    const currentPath = window.location.pathname
    const cleanPath = currentPath.replace(/^\/(fr|en|ar)(\/|$)/, '/')

    // HTML dir
    const pageDiv = document.getElementById('page')
    if (pageDiv) {
      pageDiv.setAttribute('dir', selectedLocale === 'ar' ? 'rtl' : 'ltr')
    }

    // HTML lang
    document.documentElement.setAttribute('lang', selectedLocale)

    // Redirection Turbo
    visit(`/${selectedLocale}${cleanPath}`)
  }
}
