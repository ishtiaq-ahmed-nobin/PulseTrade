import { useEffect, useState } from 'react'
import {
    ShoppingBag,
    DollarSign,
    Package,
    Users,
    AlertTriangle,
    Clock,
} from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import { formatPrice, formatDateTime, STATUS_LABELS, STATUS_STYLES } from '../../utils/format'
import Loader from '../../components/Loader'

export default function AdminDashboardPage() {
    const [data, setData] = useState(null)
    const [error, setError] = useState('')

    useEffect(() => {
        api.get('/admin/dashboard')
            .then(({ data }) => setData(data))
            .catch((err) => setError(extractErrors(err, 'Failed to load dashboard.')))
    }, [])

    if (error) return <div className="card p-10 text-center text-rose-600">{error}</div>
    if (!data) return <Loader />

    const maxRevenue = Math.max(...data.monthly_revenue.map((m) => Number(m.revenue)), 1)

    const metrics = [
        { label: 'Total Orders', value: data.total_orders, icon: ShoppingBag, color: 'bg-sky-500' },
        { label: 'Total Revenue', value: formatPrice(data.total_revenue), icon: DollarSign, color: 'bg-emerald-500' },
        { label: 'Total Products', value: data.total_products, icon: Package, color: 'bg-indigo-500' },
        { label: 'Customers', value: data.total_users, icon: Users, color: 'bg-brand-500' },
        { label: 'Low Stock', value: data.low_stock_count, icon: AlertTriangle, color: 'bg-amber-500' },
        { label: 'Pending Orders', value: data.pending_orders, icon: Clock, color: 'bg-rose-500' },
    ]

    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Dashboard</h1>

            <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
                {metrics.map(({ label, value, icon: Icon, color }) => (
                    <div key={label} className="card p-5">
                        <span className={`flex h-10 w-10 items-center justify-center rounded-xl ${color} text-white`}>
                            <Icon size={20} />
                        </span>
                        <p className="mt-3 text-2xl font-extrabold text-brand-900 dark:text-white">{value}</p>
                        <p className="text-xs font-medium text-slate-500 dark:text-slate-400">{label}</p>
                    </div>
                ))}
            </div>

            <div className="grid gap-6 lg:grid-cols-3">
                <div className="card p-6 lg:col-span-2">
                    <h2 className="mb-6 font-bold text-brand-900 dark:text-white">Revenue (Last 6 Months)</h2>
                    {data.monthly_revenue.length === 0 ? (
                        <p className="text-sm text-slate-400">No revenue data yet.</p>
                    ) : (
                        <div className="flex h-52 items-end gap-3">
                            {data.monthly_revenue.map((m) => (
                                <div key={m.month} className="flex flex-1 flex-col items-center gap-2">
                                    <span className="text-xs font-semibold text-brand-900 dark:text-white">
                                        {formatPrice(m.revenue).replace('.00', '')}
                                    </span>
                                    <div
                                        className="w-full rounded-t-lg bg-gradient-to-t from-brand-700 to-sky-400 transition-all"
                                        style={{ height: `${Math.max((Number(m.revenue) / maxRevenue) * 130, 8)}px` }}
                                    />
                                    <span className="text-xs text-slate-400">{m.month.slice(2)}</span>
                                </div>
                            ))}
                        </div>
                    )}
                </div>

                <div className="card p-6">
                    <h2 className="mb-4 font-bold text-brand-900 dark:text-white">Top Products</h2>
                    <div className="space-y-3">
                        {data.top_products.map((p, i) => (
                            <div key={p.id} className="flex items-center gap-3">
                                <span className="w-5 text-sm font-bold text-slate-400">#{i + 1}</span>
                                <div className="min-w-0 flex-1">
                                    <p className="truncate text-sm font-semibold text-brand-900 dark:text-white">{p.name}</p>
                                    <p className="text-xs text-slate-500">{p.reviews_count} reviews</p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            <div className="card overflow-hidden">
                <div className="flex items-center justify-between border-b border-slate-200 p-5 dark:border-brand-800">
                    <h2 className="font-bold text-brand-900 dark:text-white">Recent Orders</h2>
                    <a href="/admin/orders" className="text-sm font-semibold text-sky-600 dark:text-sky-400">View all</a>
                </div>
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm">
                        <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                            <tr>
                                <th className="px-5 py-3">Order</th>
                                <th className="px-5 py-3">Customer</th>
                                <th className="px-5 py-3">Date</th>
                                <th className="px-5 py-3">Status</th>
                                <th className="px-5 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                            {data.recent_orders.map((order) => (
                                <tr key={order.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                    <td className="px-5 py-3 font-semibold text-brand-900 dark:text-white">{order.order_number}</td>
                                    <td className="px-5 py-3">{order.user?.name}</td>
                                    <td className="px-5 py-3 text-slate-500">{formatDateTime(order.created_at)}</td>
                                    <td className="px-5 py-3">
                                        <span className={`badge ${STATUS_STYLES[order.status]}`}>{STATUS_LABELS[order.status]}</span>
                                    </td>
                                    <td className="px-5 py-3 text-right font-bold text-brand-900 dark:text-white">{formatPrice(order.total_amount)}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}
