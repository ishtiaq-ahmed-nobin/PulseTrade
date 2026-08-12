import { useCallback, useEffect, useState } from 'react'
import {
    Search,
    Trash2,
    ChevronLeft,
    ChevronRight,
    Users,
    Mail,
} from 'lucide-react'
import api from '../../services/api'
import { formatPrice, formatDate } from '../../utils/format'
import Loader from '../../components/Loader'

export default function AdminCustomersPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [q, setQ] = useState('')
    const [page, setPage] = useState(1)
    const [toast, setToast] = useState('')

    const fetchCustomers = useCallback(() => {
        setLoading(true)
        const params = { page }
        if (q) params.q = q

        api.get('/admin/customers', { params })
            .then(({ data }) => setData(data))
            .catch(() => {})
            .finally(() => setLoading(false))
    }, [q, page])

    useEffect(() => {
        fetchCustomers()
    }, [fetchCustomers])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    async function handleDelete(customer) {
        if (!window.confirm(`Delete customer "${customer.name}"? Their orders and reviews will also be removed.`)) return
        try {
            const { data: res } = await api.delete(`/admin/customers/${customer.id}`)
            setToast(res.message)
            fetchCustomers()
        } catch {
            setToast('Unable to delete customer.')
        }
    }

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Customers</h1>
            </div>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="relative min-w-[200px] flex-1">
                    <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        className="input !py-2 pl-9"
                        placeholder="Search by name, email or phone..."
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
            ) : data?.data?.length === 0 ? (
                <div className="card flex flex-col items-center gap-3 p-14 text-center">
                    <Users size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No customers found</p>
                </div>
            ) : (
                <div className="card overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                                <tr>
                                    <th className="px-5 py-3">Customer</th>
                                    <th className="px-5 py-3">Contact</th>
                                    <th className="px-5 py-3">Joined</th>
                                    <th className="px-5 py-3">Orders</th>
                                    <th className="px-5 py-3">Total Spent</th>
                                    <th className="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                                {data.data.map((customer) => (
                                    <tr key={customer.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                        <td className="px-5 py-3">
                                            <div className="flex items-center gap-3">
                                                <span className="flex h-9 w-9 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700 dark:bg-brand-800 dark:text-brand-200">
                                                    {customer.name?.charAt(0)?.toUpperCase()}
                                                </span>
                                                <p className="font-semibold text-brand-900 dark:text-white">{customer.name}</p>
                                            </div>
                                        </td>
                                        <td className="px-5 py-3">
                                            <div className="flex items-center gap-1.5 text-slate-500">
                                                <Mail size={14} /> {customer.email}
                                            </div>
                                            {customer.phone && (
                                                <p className="mt-0.5 text-xs text-slate-400">{customer.phone}</p>
                                            )}
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{formatDate(customer.created_at)}</td>
                                        <td className="px-5 py-3 font-semibold text-brand-900 dark:text-white">{customer.orders_count}</td>
                                        <td className="px-5 py-3 font-semibold text-brand-900 dark:text-white">{formatPrice(customer.orders_sum_total_amount || 0)}</td>
                                        <td className="px-5 py-3">
                                            <div className="flex justify-end gap-1">
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(customer)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                                    aria-label={`Delete ${customer.name}`}
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
                    {data && data.last_page > 1 && (
                        <div className="flex items-center justify-between border-t border-slate-200 px-5 py-3 dark:border-brand-800">
                            <p className="text-sm text-slate-500">
                                Page {data.current_page} of {data.last_page}
                            </p>
                            <div className="flex gap-2">
                                <button
                                    type="button"
                                    disabled={data.current_page <= 1}
                                    onClick={() => setPage((p) => p - 1)}
                                    className="btn btn-outline !p-2"
                                    aria-label="Previous page"
                                >
                                    <ChevronLeft size={16} />
                                </button>
                                <button
                                    type="button"
                                    disabled={data.current_page >= data.last_page}
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
