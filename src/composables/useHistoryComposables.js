import axios from '../libs/axiosInstance'

export const getHistory = async () => {
  const { data } = await axios.get('/history')
  return data
}
