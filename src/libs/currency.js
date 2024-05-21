const locale = 'id-ID'

export const toRupiah = (value, currency = false) => {
  let current = ''
  if (currency) {
    current = 'currency'
  } else {
    current = 'decimal'
  }
  const floatValue = parseFloat(value);
  const roundedValue = Math.floor(floatValue);
  const formatSaldo = new Intl.NumberFormat(locale, {
    style: current,
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(roundedValue);

  return formatSaldo.replace(/\,00$/, '').replace(/\./g, ',');;
  // return `Rp ${formated}`
  // return formatSaldo
  // return roundedValue;
}
