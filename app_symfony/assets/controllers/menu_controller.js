// import { Controller } from '@hotwired/stimulus'
// import { visit } from '@hotwired/turbo'

// export default class extends Controller {
//   static targets = ['mobileMenu', 'burgerToggle', 'profileBtn', 'profileMenu', 'langSwitcher']

//   connect() {
//     this.handleOutsideClick = this.handleOutsideClick.bind(this)
//     document.addEventListener('click', this.handleOutsideClick)
//   }

//   disconnect() {
//     document.removeEventListener('click', this.handleOutsideClick)
//   }

//   toggleMobileMenu(event) {
//     event.stopPropagation()
//     const isOpen = this.mobileMenuTarget.classList.contains('translate-x-0')
//     this.mobileMenuTarget.classList.toggle('translate-x-0', !isOpen)
//     this.mobileMenuTarget.classList.toggle('-translate-x-full', isOpen)
//     this.burgerToggleTarget.setAttribute('aria-expanded', String(!isOpen))
//   }

//   toggleProfileMenu(event) {
//     event.stopPropagation()
//     const isHidden = this.profileMenuTarget.classList.contains('hidden')
//     this.profileMenuTarget.classList.toggle('hidden', !isHidden)
//     this.profileBtnTarget.setAttribute('aria-expanded', String(isHidden))
//   }

//   handleOutsideClick(event) {
//     if (
//       this.hasProfileMenuTarget &&
//       !this.profileMenuTarget.contains(event.target) &&
//       !this.profileBtnTarget.contains(event.target)
//     ) {
//       this.profileMenuTarget.classList.add('hidden')
//       this.profileBtnTarget.setAttribute('aria-expanded', 'false')
//     }

//     if (
//       this.hasMobileMenuTarget &&
//       !this.mobileMenuTarget.contains(event.target) &&
//       !this.burgerToggleTarget.contains(event.target)
//     ) {
//       this.mobileMenuTarget.classList.remove('translate-x-0')
//       this.mobileMenuTarget.classList.add('-translate-x-full')
//       this.burgerToggleTarget.setAttribute('aria-expanded', 'false')
//     }
//   }

//   submitLang(event) {
//     const selectedLocale = event.target.value
//     const currentPath = window.location.pathname
//     const cleanPath = currentPath.replace(/^\/(fr|en|ar)(\/|$)/, '/')

//     // Met à jour la direction sur le div#page
//     const pageDiv = document.getElementById('page')
//     if (pageDiv) {
//       pageDiv.setAttribute('dir', selectedLocale === 'ar' ? 'rtl' : 'ltr')
//     }

//     // Met à jour aussi lang pour accessibilité
//     document.documentElement.setAttribute('lang', selectedLocale)

//     visit(`/${selectedLocale}${cleanPath}`)
//   }
// }
