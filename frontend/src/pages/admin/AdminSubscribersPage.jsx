import { useCallback, useEffect, useState } from 'react'
import {
    Search,
    Trash2,
    ChevronLeft,
    ChevronRight,
    Mail,
    MailOpen,
    Power,
} from 'lucide-react'
import api from '../../services/api'
import { formatDate } from '../../utils/format'
import Loader from '../../components/Loader'

export default function AdminSubscribersPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [q, setQ] = useState('')
    const [page, setPage] = useState(1)
    const [toast, setToast] = useState('')

    const fetchSubscribers = useCallback(() => {
        setLoading(true)
        const params = { page }
        if (q) params.q = q

        api.get('/admin/subscribers', { params })
            .then(({ data }) => setData(data))
            .catch(() => {})
            .finally(() => setLoading(false))
    }, [q, page])

    useEffect(() => {
        fetchSubscribers()
    }, [fetchSubscribers])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    async function handleToggle(subscriber) {
        try {
            const { data: res } = await api.patch(`/admin/subscribers/${subscriber.id}/toggle`)
            setToast(res.message)
            fetchSubscribers()
        } catch {
            setToast('Unable to update subscriber.')
        }
    }

    async function handleDelete(subscriber) {
        if (!window.confirm(`Delete subscriber "${subscriber.email}"?`)) return
        try {
            const { data: res } = await api.delete(`/admin/subscribers/${subscriber.id}`)
            setToast(res.message)
            fetchSubscribers()
        } catch {
            setToast('Unable to delete subscriber.')
        }
    }

    const subscribers = data?.subscribers

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Subscribers</h1>
            </div>

            {data && (
                <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <div className="card p-5">
                        <span className="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500 text-white">
                            <Mail size={20} />
                        </span>
                        <p className="mt-3 text-2xl font-extrabold text-brand-900 dark:text-white">{data.total}</p>
                        <p className="text-xs font-medium text-slate-500 dark:text-slate-400">Total Subscribers</p>
                    </div>
                    <div className="card p-5">
                        <span className="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white">
                            <MailOpen size={20} />
                        </span>
                        <p className="mt-3 text-2xl font-extrabold text-brand-900 dark:text-white">{data.active}</p>
                        <p className="text-xs font-medium text-slate-500 dark:text-slate-400">Active Subscribers</p>
                    </div>
                </div>
            )}

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="relative min-w-[200px] flex-1">
                    <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        className="input !py-2 pl-9"
                        placeholder="Search by name or email..."
                        value={q}
                        onChange={(e) => {
                            setQ(e.target.value)
                            setPage(1)
                        }}
                    />
                </div>
            </div>

            {toast && (
                <div className="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                    {toast}
                </div>
            )}

            {loading ? (
                <Loader />
            ) : subscribers?.data?.length === 0 ? (
                <div className="card flex flex-col items-center gap-3 p-14 text-center">
                    <Mail size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No subscribers yet</p>
                </div>
            ) : (
                <div className="card overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                                <tr>
                                    <th className="px-5 py-3">Name</th>
                                    <th className="px-5 py-3">Email</th>
                                    <th className="px-5 py-3">Subscribed</th>
                                    <th className="px-5 py-3">Status</th>
                                    <th className="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                                {subscribers.data.map((subscriber) => (
                                    <tr key={subscriber.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                        <td className="px-5 py-3 font-semibold text-brand-900 dark:text-white">{subscriber.name || '—'}</td>
                                        <td className="px-5 py-3 text-slate-500">{subscriber.email}</td>
                                        <td className="px-5 py-3 text-slate-500">{formatDate(subscriber.subscribed_at || subscriber.created_at)}</td>
                                        <td className="px-5 py-3">
                                            <span className={`badge ${subscriber.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-slate-100 text-slate-500 dark:bg-brand-800 dark:text-slate-400'}`}>
                                                {subscriber.is_active ? 'Active' : 'Unsubscribed'}
                                            </span>
                                        </td>
                                        <td className="px-5 py-3">
                                            <div className="flex justify-end gap-1">
                                                <button
                                                    type="button"
                                                    onClick={() => handleToggle(subscriber)}
                                                    className={`rounded-lg p-2 hover:bg-brand-50 dark:hover:bg-brand-800 ${subscriber.is_active ? 'text-slate-500 hover:text-amber-600' : 'text-emerald-500 hover:text-emerald-600'}`}
                                                    aria-label={subscriber.is_active ? 'Deactivate' : 'Activate'}
                                                >
                                                    <Power size={16} />
                                                </button>
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(subscriber)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                                    aria-label={`Delete ${subscriber.email}`}
                                                >
                                                    <Trash2 size={16} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {subscribers && subscribers.last_page > 1 && (
                        <div className="flex items-center justify-between border-t border-slate-200 px-5 py-3 dark:border-brand-800">
                            <p className="text-sm text-slate-500">
                                Page {subscribers.current_page} of {subscribers.last_page}
                            </p>
                            <div className="flex gap-2">
                                <button
                                    type="button"
                                    disabled={subscribers.current_page <= 1}
                                    onClick={() => setPage((p) => p - 1)}
                                    className="btn btn-outline !p-2"
                                    aria-label="Previous page"
                                >
                                    <ChevronLeft size={16} />
                                </button>
                                <button
                                    type="button"
                                    disabled={subscribers.current_page >= subscribers.last_page}
                                    onClick={() => setPage((p) => p + 1)}
                                    className="btn btn-outline !p-2"
                                    aria-label="Next page"
                                >
                                    <ChevronRight size={16} />
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            )}
        </div>
    )
}
