import { useCallback, useEffect, useState } from 'react'
import {
    FileDown,
    FileText,
    DollarSign,
    ShoppingBag,
    CheckCircle,
    Receipt,
    TrendingUp,
} from 'lucide-react'
import api, { extractErrors, API_BASE_URL } from '../../services/api'
import { formatPrice, formatDate } from '../../utils/format'
import Loader from '../../components/Loader'

const toInputValue = (d) => {
    const y = d.getFullYear()
    const m = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')
    return `${y}-${m}-${day}`
}

function initialRange() {
    const to = new Date()
    const from = new Date()
    from.setDate(from.getDate() - 30)
    return { from: toInputValue(from), to: toInputValue(to) }
}

export default function AdminReportsPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState('')
    const [range, setRange] = useState(initialRange)

    const fetchReport = useCallback(() => {
        setLoading(true)
        setError('')
        api.get('/admin/reports/sales', { params: range })
            .then(({ data }) => setData(data))
            .catch((err) => setError(extractErrors(err, 'Failed to load report.')))
            .finally(() => setLoading(false))
    }, [range.from, range.to])

    useEffect(() => {
        fetchReport()
    }, [fetchReport])

    const exportUrl = (path) =>
        `${API_BASE_URL}/v1/admin/reports/sales/${path}?from=${range.from}&to=${range.to}`

    const maxDaily = data ? Math.max(...data.daily_sales.map((d) => Number(d.revenue)), 1) : 1
    const maxTop = data ? Math.max(...data.top_products.map((p) => Number(p.total_revenue)), 1) : 1

    const metrics = data
        ? [
              { label: 'Total Revenue', value: formatPrice(data.total_revenue), icon: DollarSign, color: 'bg-emerald-500' },
              { label: 'Total Orders', value: data.total_orders, icon: ShoppingBag, color: 'bg-sky-500' },
              { label: 'Paid Orders', value: data.paid_orders, icon: CheckCircle, color: 'bg-indigo-500' },
              { label: 'Avg Order Value', value: formatPrice(data.avg_order_value), icon: Receipt, color: 'bg-amber-500' },
          ]
        : []

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Sales Report</h1>
                <div className="flex gap-2">
                    <a href={exportUrl('csv')} className="btn btn-outline">
                        <FileDown size={16} /> Export CSV
                    </a>
                    <a href={exportUrl('pdf')} className="btn btn-primary">
                        <FileText size={16} /> Export PDF
                    </a>
                </div>
            </div>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="flex items-center gap-2">
                    <label className="text-sm font-medium text-slate-600 dark:text-slate-300">From</label>
                    <input
                        type="date"
                        className="input !w-auto !py-2"
                        value={range.from}
                        onChange={(e) => setRange((r) => ({ ...r, from: e.target.value }))}
                    />
                </div>
                <div className="flex items-center gap-2">
                    <label className="text-sm font-medium text-slate-600 dark:text-slate-300">To</label>
                    <input
                        type="date"
                        className="input !w-auto !py-2"
                        value={range.to}
                        onChange={(e) => setRange((r) => ({ ...r, to: e.target.value }))}
                    />
                </div>
                <button type="button" onClick={fetchReport} className="btn btn-primary !py-2">
                    Apply
                </button>
            </div>

            {error && (
                <div className="card p-10 text-center text-rose-600">{error}</div>
            )}

            {loading ? (
                <Loader />
            ) : (
                data && (
                    <>
                        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
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
                                <div className="mb-6 flex items-center gap-2">
                                    <TrendingUp size={18} className="text-sky-500" />
                                    <h2 className="font-bold text-brand-900 dark:text-white">Daily Sales</h2>
                                </div>
                                {data.daily_sales.length === 0 ? (
                                    <p className="text-sm text-slate-400">No sales in this period.</p>
                                ) : (
                                    <div className="flex h-52 items-end gap-2">
                                        {data.daily_sales.map((d) => (
                                            <div key={d.date} className="flex flex-1 flex-col items-center gap-2">
                                                <span className="text-[10px] font-semibold text-brand-900 dark:text-white">
                                                    {formatPrice(d.revenue).replace('.00', '')}
                                                </span>
                                                <div
                                                    className="w-full rounded-t-lg bg-gradient-to-t from-brand-700 to-sky-400 transition-all"
                                                    style={{ height: `${Math.max((Number(d.revenue) / maxDaily) * 130, 8)}px` }}
                                                />
                                                <span className="text-[10px] text-slate-400">{formatDate(d.date)}</span>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>

                            <div className="card p-6">
                                <h2 className="mb-4 font-bold text-brand-900 dark:text-white">Top Products</h2>
                                <div className="space-y-4">
                                    {data.top_products.length === 0 ? (
                                        <p className="text-sm text-slate-400">No products sold in this period.</p>
                                    ) : (
                                        data.top_products.map((p) => (
                                            <div key={p.id} className="flex items-center gap-3">
                                                <img src={p.image} alt={p.name} className="h-10 w-10 rounded-lg object-cover" />
                                                <div className="min-w-0 flex-1">
                                                    <p className="truncate text-sm font-semibold text-brand-900 dark:text-white">{p.name}</p>
                                                    <p className="text-xs text-slate-500">{p.qty_sold} sold</p>
                                                    <div className="mt-1 h-1.5 w-full rounded-full bg-slate-100 dark:bg-brand-800">
                                                        <div
                                                            className="h-full rounded-full bg-sky-500"
                                                            style={{ width: `${(Number(p.total_revenue) / maxTop) * 100}%` }}
                                                        />
                                                    </div>
                                                </div>
                                                <span className="text-sm font-bold text-brand-900 dark:text-white">{formatPrice(p.total_revenue)}</span>
                                            </div>
                                        ))
                                    )}
                                </div>
                            </div>
                        </div>
                    </>
                )
            )}
        </div>
    )
}
