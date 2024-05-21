import axios from "axios"

const instance = axios.create({
	baseURL: 'https://66443b0c6c6a656587098fc9.mockapi.io/api',
	headers: {
		'Content-Type': 'application/json',
	}
})

export default instance