import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import './index.css'
import { setCurrency } from './utils/format'

async function bootstrap() {
    try {
        const base =
            import.meta.env.VITE_API_BASE_URL || window.location.origin + '/api'
        const res = await fetch(`${base}/v1/settings/public`)
        const data = await res.json()
        setCurrency(data?.settings?.store_currency)
    } catch {
        // Keep the default (USD) if the settings can't be loaded.
    }

    ReactDOM.createRoot(document.getElementById('root')).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    )
}

bootstrap()
