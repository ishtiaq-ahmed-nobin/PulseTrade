import { useEffect, useState } from 'react'
import { Save, Loader2, Settings as SettingsIcon, Store, Search, Truck, Layers } from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import Loader from '../../components/Loader'

const CURRENCIES = [
    'USD', 'EUR', 'GBP', 'JPY', 'INR', 'BDT', 'CAD', 'AUD', 'CNY', 'BRL', 'KRW',
    'MXN', 'SEK', 'NOK', 'DKK', 'CHF', 'PLN', 'CZK', 'ZAR', 'SGD', 'HKD',
]

const GROUP_LABELS = {
    store: { label: 'Store Information', icon: Store },
    seo: { label: 'SEO', icon: Search },
    shipping: { label: 'Shipping', icon: Truck },
    general: { label: 'General', icon: Layers },
}

const NUMERIC_KEYS = ['free_shipping_threshold', 'shipping_cost']

function humanize(key) {
    return key
        .split('_')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ')
}

export default function AdminSettingsPage() {
    const [settings, setSettings] = useState(null)
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState('')
    const [form, setForm] = useState({})
    const [saving, setSaving] = useState(false)
    const [toast, setToast] = useState('')

    useEffect(() => {
        api.get('/admin/settings')
            .then(({ data }) => {
                setSettings(data.settings)
                const next = {}
                Object.values(data.settings).forEach((group) => {
                    group.forEach((item) => {
                        next[item.key] = item.value ?? ''
                    })
                })
                setForm(next)
            })
            .catch((err) => setError(extractErrors(err, 'Failed to load settings.')))
            .finally(() => setLoading(false))
    }, [])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    function update(key, value) {
        setForm((f) => ({ ...f, [key]: value }))
    }

    async function handleSubmit(e) {
        e.preventDefault()
        setSaving(true)
        try {
            const { data: res } = await api.patch('/admin/settings', { settings: form })
            setToast(res.message)
        } catch (err) {
            setToast(extractErrors(err, 'Unable to save settings.'))
        } finally {
            setSaving(false)
        }
    }

    if (loading) return <Loader />
    if (error) return <div className="card p-10 text-center text-rose-600">{error}</div>

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Store Settings</h1>
                <button type="submit" disabled={saving} className="btn btn-primary">
                    {saving && <Loader2 size={16} className="animate-spin" />}
                    <Save size={16} /> Save Settings
                </button>
            </div>

            {toast && (
                <div className="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                    {toast}
                </div>
            )}

            {Object.entries(settings).map(([group, items]) => {
                const meta = GROUP_LABELS[group] || { label: humanize(group), icon: SettingsIcon }
                const Icon = meta.icon
                return (
                    <div key={group} className="card overflow-hidden">
                        <div className="flex items-center gap-2 border-b border-slate-200 bg-slate-50 px-6 py-4 dark:border-brand-800 dark:bg-brand-800/50">
                            <Icon size={18} className="text-sky-500" />
                            <h2 className="font-bold text-brand-900 dark:text-white">{meta.label}</h2>
                        </div>
                        <div className="grid gap-4 p-6 sm:grid-cols-2">
                            {items.map((item) => (
                                <div key={item.key}>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        {humanize(item.key)}
                                    </label>
                                    {item.key === 'store_currency' ? (
                                        <select className="input" value={form[item.key] || 'USD'} onChange={(e) => update(item.key, e.target.value)}>
                                            {CURRENCIES.map((code) => (
                                                <option key={code} value={code}>{code}</option>
                                            ))}
                                        </select>
                                    ) : NUMERIC_KEYS.includes(item.key) ? (
                                        <input
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            className="input"
                                            value={form[item.key] ?? ''}
                                            onChange={(e) => update(item.key, e.target.value)}
                                        />
                                    ) : (
                                        <input
                                            type="text"
                                            className="input"
                                            value={form[item.key] ?? ''}
                                            onChange={(e) => update(item.key, e.target.value)}
                                        />
                                    )}
                                </div>
                            ))}
                        </div>
                    </div>
                )
            })}
        </form>
    )
}
