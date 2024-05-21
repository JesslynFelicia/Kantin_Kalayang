import axios from '../libs/axiosInstance'

export const getRekap = async () => {
  const { data } = await axios.get('/rekap')
  return data
}

export const getRekapSingle = async (id) => {
  const { data } = await axios.get(`/rekap/${id}`)
  return data
}
