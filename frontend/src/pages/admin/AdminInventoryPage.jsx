import { useCallback, useEffect, useState } from 'react'
import {
    Search,
    ChevronLeft,
    ChevronRight,
    Save,
    Boxes,
    Package,
    AlertTriangle,
    XCircle,
    DollarSign,
} from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import { formatPrice, STOCK_STYLES, stockLabel } from '../../utils/format'
import Loader from '../../components/Loader'

export default function AdminInventoryPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [q, setQ] = useState('')
    const [stockStatus, setStockStatus] = useState('')
    const [page, setPage] = useState(1)
    const [editingId, setEditingId] = useState(null)
    const [draft, setDraft] = useState('')
    const [savingId, setSavingId] = useState(null)
    const [toast, setToast] = useState('')

    const fetchInventory = useCallback(() => {
        setLoading(true)
        const params = { page }
        if (q) params.q = q
        if (stockStatus) params.stock_status = stockStatus

        api.get('/admin/inventory', { params })
            .then(({ data }) => setData(data))
            .catch(() => {})
            .finally(() => setLoading(false))
    }, [q, stockStatus, page])

    useEffect(() => {
        fetchInventory()
    }, [fetchInventory])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    function startEdit(product) {
        setEditingId(product.id)
        setDraft(product.stock)
    }

    function cancelEdit() {
        setEditingId(null)
        setDraft('')
    }

    async function saveStock(product) {
        const value = Number(draft)
        if (!Number.isInteger(value) || value < 0) return

        setSavingId(product.id)
        try {
            const { data: res } = await api.patch(`/admin/inventory/${product.id}/stock`, { stock: value })
            setToast(res.message)
            setEditingId(null)
            setDraft('')
            fetchInventory()
        } catch (err) {
            setToast(extractErrors(err, 'Unable to update stock.'))
        } finally {
            setSavingId(null)
        }
    }

    const stats = data?.stats
    const products = data?.products

    const statCards = stats
        ? [
              { label: 'Total Products', value: stats.total_products, icon: Package, color: 'bg-indigo-500' },
              { label: 'Units in Stock', value: stats.total_stock, icon: Boxes, color: 'bg-sky-500' },
              { label: 'Low Stock', value: stats.low_stock, icon: AlertTriangle, color: 'bg-amber-500' },
              { label: 'Out of Stock', value: stats.out_of_stock, icon: XCircle, color: 'bg-rose-500' },
              { label: 'Stock Value', value: formatPrice(stats.total_value), icon: DollarSign, color: 'bg-emerald-500' },
          ]
        : []

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Inventory</h1>
            </div>

            <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                {statCards.map(({ label, value, icon: Icon, color }) => (
                    <div key={label} className="card p-5">
                        <span className={`flex h-10 w-10 items-center justify-center rounded-xl ${color} text-white`}>
                            <Icon size={20} />
                        </span>
                        <p className="mt-3 text-2xl font-extrabold text-brand-900 dark:text-white">{value}</p>
                        <p className="text-xs font-medium text-slate-500 dark:text-slate-400">{label}</p>
                    </div>
                ))}
            </div>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="relative min-w-[200px] flex-1">
                    <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        className="input !py-2 pl-9"
                        placeholder="Search products..."
                        value={q}
                        onChange={(e) => {
                            setQ(e.target.value)
                            setPage(1)
                        }}
                    />
                </div>
                <select className="input !w-auto !py-2" value={stockStatus} onChange={(e) => { setStockStatus(e.target.value); setPage(1) }}>
                    <option value="">All Stock</option>
                    <option value="in">In Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                </select>
            </div>

            {toast && (
                <div className="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                    {toast}
                </div>
            )}

            {loading ? (
                <Loader />
            ) : (
                <div className="card overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                                <tr>
                                    <th className="px-5 py-3">Product</th>
                                    <th className="px-5 py-3">Category</th>
                                    <th className="px-5 py-3">Price</th>
                                    <th className="px-5 py-3">Status</th>
                                    <th className="px-5 py-3">Stock</th>
                                    <th className="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                                {products.data.map((product) => (
                                    <tr key={product.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                        <td className="px-5 py-3">
                                            <div className="flex items-center gap-3">
                                                <img src={product.image_url} alt={product.name} className="h-10 w-10 rounded-lg object-cover" />
                                                <p className="font-semibold text-brand-900 dark:text-white">{product.name}</p>
                                            </div>
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{product.category?.name}</td>
                                        <td className="px-5 py-3 font-semibold text-brand-900 dark:text-white">{formatPrice(product.final_price)}</td>
                                        <td className="px-5 py-3">
                                            <span className={`badge ${STOCK_STYLES[product.stock_status]}`}>{stockLabel(product.stock_status)}</span>
                                        </td>
                                        <td className="px-5 py-3">
                                            {editingId === product.id ? (
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="1"
                                                    autoFocus
                                                    className="input !w-24 !py-1.5"
                                                    value={draft}
                                                    onChange={(e) => setDraft(e.target.value)}
                                                    onKeyDown={(e) => {
                                                        if (e.key === 'Enter') saveStock(product)
                                                        if (e.key === 'Escape') cancelEdit()
                                                    }}
                                                />
                                            ) : (
                                                <span className="font-semibold text-brand-900 dark:text-white">{product.stock}</span>
                                            )}
                                        </td>
                                        <td className="px-5 py-3">
                                            <div className="flex justify-end gap-2">
                                                {editingId === product.id ? (
                                                    <>
                                                        <button
                                                            type="button"
                                                            onClick={() => saveStock(product)}
                                                            disabled={savingId === product.id}
                                                            className="btn btn-primary !px-3 !py-2"
                                                        >
                                                            {savingId === product.id ? (
                                                                <span className="h-4 w-4 animate-spin rounded-full border-2 border-white/40 border-t-white" />
                                                            ) : (
                                                                <Save size={16} />
                                                            )}
                                                        </button>
                                                        <button type="button" onClick={cancelEdit} className="btn btn-outline !px-3 !py-2">
                                                            Cancel
                                                        </button>
                                                    </>
                                                ) : (
                                                    <button type="button" onClick={() => startEdit(product)} className="btn btn-outline !px-3 !py-2">
                                                        Adjust
                                                    </button>
                                                )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    {products && products.last_page > 1 && (
                        <div className="flex items-center justify-between border-t border-slate-200 px-5 py-3 dark:border-brand-800">
                            <p className="text-sm text-slate-500">
                                Page {products.current_page} of {products.last_page}
                            </p>
                            <div className="flex gap-2">
                                <button
                                    type="button"
                                    disabled={products.current_page <= 1}
                                    onClick={() => setPage((p) => p - 1)}
                                    className="btn btn-outline !p-2"
                                    aria-label="Previous page"
                                >
                                    <ChevronLeft size={16} />
                                </button>
                                <button
                                    type="button"
                                    disabled={products.current_page >= products.last_page}
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
