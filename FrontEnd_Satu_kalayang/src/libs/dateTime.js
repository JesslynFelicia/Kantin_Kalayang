import moment from 'moment-timezone'

export const formatToDatetime = (isoTime) => {
  const indonesiaTime = moment(isoTime).tz('Asia/Jakarta')
  return indonesiaTime.format('YYYY-MM-DD HH:mm:ss')
}

export const formatToDate = (isoTime) => {
  const indonesiaTime = moment(isoTime).tz('Asia/Jakarta')
  return indonesiaTime.format('YYYY-MM-DD ')
}

export const today = () => {
  const indonesiaTime = moment().tz('Asia/Jakarta')
  return indonesiaTime.format('YYYY-MM-DD ')
}
