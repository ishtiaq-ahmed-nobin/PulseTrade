import { useCallback, useEffect, useState } from 'react'
import { Search, ChevronDown, Loader2, ShoppingBag, ChevronLeft, ChevronRight } from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import {
    formatPrice,
    formatDateTime,
    STATUS_LABELS,
    STATUS_STYLES,
    PAYMENT_LABELS,
} from '../../utils/format'
import { getImageUrl } from '../../utils/image'
import Loader from '../../components/Loader'

const STATUSES = ['pending', 'processing', 'shipped', 'completed', 'cancelled']
const PAYMENTS = ['pending', 'paid', 'failed']

export default function AdminOrdersPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [q, setQ] = useState('')
    const [status, setStatus] = useState('')
    const [paymentStatus, setPaymentStatus] = useState('')
    const [page, setPage] = useState(1)
    const [expanded, setExpanded] = useState(null)
    const [toast, setToast] = useState('')
    const [error, setError] = useState('')

    const fetchOrders = useCallback(() => {
        setLoading(true)
        setError('')
        const params = { page }
        if (q) params.q = q
        if (status) params.status = status
        if (paymentStatus) params.payment_status = paymentStatus

        api.get('/admin/orders', { params })
            .then(({ data }) => setData(data))
            .catch((err) => setError(extractErrors(err, 'Failed to load orders.')))
            .finally(() => setLoading(false))
    }, [q, status, paymentStatus, page])

    useEffect(() => {
        fetchOrders()
    }, [fetchOrders])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    async function handleStatusChange(order, field, value) {
        const payload =
            field === 'status'
                ? { status: value, payment_status: order.payment_status }
                : { status: order.status, payment_status: value }

        try {
            const { data: res } = await api.patch(`/admin/orders/${order.id}/status`, payload)
            setToast(res.message)
            fetchOrders()
        } catch {
            setToast('Unable to update order.')
        }
    }

    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Orders</h1>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="relative min-w-[220px] flex-1">
                    <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        className="input !py-2 pl-9"
                        placeholder="Search order # or customer..."
                        value={q}
                        onChange={(e) => { setQ(e.target.value); setPage(1) }}
                    />
                </div>
                <select className="input !w-auto !py-2" value={status} onChange={(e) => { setStatus(e.target.value); setPage(1) }}>
                    <option value="">All Statuses</option>
                    {STATUSES.map((s) => (
                        <option key={s} value={s}>{STATUS_LABELS[s]}</option>
                    ))}
                </select>
                <select className="input !w-auto !py-2" value={paymentStatus} onChange={(e) => { setPaymentStatus(e.target.value); setPage(1) }}>
                    <option value="">All Payments</option>
                    {PAYMENTS.map((p) => (
                        <option key={p} value={p}>{PAYMENT_LABELS[p]}</option>
                    ))}
                </select>
            </div>

            {toast && (
                <div className="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                    {toast}
                </div>
            )}

            {loading ? (
                <Loader />
            ) : error ? (
                <div className="card p-10 text-center text-rose-600">{error}</div>
            ) : data?.data?.length === 0 ? (
                <div className="card flex flex-col items-center gap-3 p-14 text-center">
                    <ShoppingBag size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No orders found</p>
                </div>
            ) : (
                <>
                    <div className="space-y-3">
                        {data.data.map((order) => (
                            <div key={order.id} className="card overflow-hidden">
                                <button
                                    type="button"
                                    onClick={() => setExpanded(expanded === order.id ? null : order.id)}
                                    className="flex w-full flex-wrap items-center justify-between gap-3 p-5 text-left"
                                >
                                    <div>
                                        <p className="font-bold text-brand-900 dark:text-white">{order.order_number}</p>
                                        <p className="text-xs text-slate-500 dark:text-slate-400">
                                            {order.user?.name} · {order.user?.email} · {formatDateTime(order.created_at)}
                                        </p>
                                    </div>
                                    <div className="flex flex-wrap items-center gap-3">
                                        <span className={`badge ${STATUS_STYLES[order.status]}`}>{STATUS_LABELS[order.status]}</span>
                                        <span className="badge bg-slate-100 text-slate-700 dark:bg-brand-800 dark:text-slate-300">
                                            {PAYMENT_LABELS[order.payment_status]}
                                        </span>
                                        <span className="font-bold text-brand-900 dark:text-white">{formatPrice(order.total_amount)}</span>
                                        <ChevronDown
                                            size={18}
                                            className={`text-slate-400 transition-transform ${expanded === order.id ? 'rotate-180' : ''}`}
                                        />
                                    </div>
                                </button>

                                {expanded === order.id && (
                                    <div className="border-t border-slate-200 p-5 dark:border-brand-800">
                                        <div className="grid gap-6 lg:grid-cols-[1fr_320px]">
                                            <div>
                                                <h3 className="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                                    Items
                                                </h3>
                                                <div className="space-y-2">
                                                    {order.items.map((item) => (
                                                        <div key={item.id} className="flex items-center gap-3">
                                                            <img
                                                                src={getImageUrl(item.product)}
                                                                alt={item.product.name}
                                                                className="h-12 w-12 rounded-lg object-cover"
                                                            />
                                                            <div className="min-w-0 flex-1">
                                                                <p className="truncate text-sm font-semibold text-brand-900 dark:text-white">
                                                                    {item.product.name}
                                                                </p>
                                                                <p className="text-xs text-slate-500">{formatPrice(item.price)} × {item.quantity}</p>
                                                            </div>
                                                            <span className="font-semibold text-brand-900 dark:text-white">
                                                                {formatPrice(item.price * item.quantity)}
                                                            </span>
                                                        </div>
                                                    ))}
                                                </div>
                                            </div>

                                            <div className="space-y-4">
                                                <div>
                                                    <h3 className="mb-2 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                                        Shipping Details
                                                    </h3>
                                                    <p className="text-sm text-slate-600 dark:text-slate-300">{order.shipping_address}</p>
                                                    <p className="mt-1 text-sm text-slate-600 dark:text-slate-300">Phone: {order.shipping_phone}</p>
                                                    <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                        Payment: {PAYMENT_LABELS[order.payment_method]}
                                                    </p>
                                                </div>

                                                <div>
                                                    <h3 className="mb-2 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                                        Update Status
                                                    </h3>
                                                    <div className="flex items-center gap-2">
                                                        <select
                                                            value={order.status}
                                                            onChange={(e) => handleStatusChange(order, 'status', e.target.value)}
                                                            className="input !w-auto !py-2"
                                                        >
                                                            {STATUSES.map((s) => (
                                                                <option key={s} value={s}>{STATUS_LABELS[s]}</option>
                                                            ))}
                                                        </select>
                                                        <select
                                                            value={order.payment_status}
                                                            onChange={(e) => handleStatusChange(order, 'payment_status', e.target.value)}
                                                            className="input !w-auto !py-2"
                                                        >
                                                            {PAYMENTS.map((p) => (
                                                                <option key={p} value={p}>{PAYMENT_LABELS[p]}</option>
                                                            ))}
                                                        </select>
                                                    </div>
                                                </div>

                                                <div className="space-y-1 border-t border-slate-200 pt-3 text-sm dark:border-brand-800">
                                                    <div className="flex justify-between text-slate-500">
                                                        <span>Subtotal</span>
                                                        <span>{formatPrice(order.subtotal)}</span>
                                                    </div>
                                                    {order.discount_amount > 0 && (
                                                        <div className="flex justify-between text-emerald-600">
                                                            <span>Discount</span>
                                                            <span>-{formatPrice(order.discount_amount)}</span>
                                                        </div>
                                                    )}
                                                    <div className="flex justify-between font-bold text-brand-900 dark:text-white">
                                                        <span>Total</span>
                                                        <span>{formatPrice(order.total_amount)}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>

                    {data && data.last_page > 1 && (
                        <div className="flex items-center justify-between">
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
                </>
            )}
        </div>
    )
}
