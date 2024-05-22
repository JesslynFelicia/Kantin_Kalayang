import { Loading, QSpinnerGears } from 'quasar';

export const showLoading = () => {
  Loading.show({
    spinner: QSpinnerGears,
    // message: 'Tunggu sebentar...',
    boxClass: 'bg-yellow-2',
    spinnerColor: 'yellow-8',
  })
}

export const hideLoading = () => {
  Loading.hide()
}
