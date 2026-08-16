import axios from 'axios'

export const API_BASE_URL =
    import.meta.env.VITE_API_BASE_URL || window.location.origin + '/api'

export const STORAGE_BASE_URL =
    import.meta.env.VITE_STORAGE_BASE_URL || window.location.origin + '/storage'

const api = axios.create({
    // laravel call
    baseURL: API_BASE_URL + '/v1',
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
})

api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            const authEvent = new CustomEvent('auth:unauthorized')
            window.dispatchEvent(authEvent)
        }
        return Promise.reject(error)
    }
)

export function extractErrors(error, fallback = 'Something went wrong.') {
    if (!error.response?.data) return fallback

    const data = error.response.data
    if (typeof data.message === 'string' && !data.errors) return data.message
    if (data.errors) {
        const messages = []
        for (const key of Object.keys(data.errors)) {
            messages.push(...data.errors[key])
        }
        return messages.length ? messages : fallback
    }
    return fallback
}

export default api
