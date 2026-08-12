import { useCallback, useEffect, useState } from 'react'
import {
    Plus,
    Search,
    Trash2,
    X,
    Loader2,
    ChevronLeft,
    ChevronRight,
    TicketPercent,
    Power,
} from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import { formatPrice, getCurrencySymbol, formatDate } from '../../utils/format'
import Loader from '../../components/Loader'

const EMPTY_FORM = {
    code: '',
    type: 'percentage',
    value: '',
    min_order: '',
    usage_limit: '',
    expires_at: '',
    is_active: true,
}

export default function AdminCouponsPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [q, setQ] = useState('')
    const [page, setPage] = useState(1)
    const [modalOpen, setModalOpen] = useState(false)
    const [form, setForm] = useState({ ...EMPTY_FORM })
    const [saving, setSaving] = useState(false)
    const [formError, setFormError] = useState('')
    const [toast, setToast] = useState('')

    const fetchCoupons = useCallback(() => {
        setLoading(true)
        const params = { page }
        if (q) params.q = q

        api.get('/admin/coupons', { params })
            .then(({ data }) => setData(data))
            .catch(() => {})
            .finally(() => setLoading(false))
    }, [q, page])

    useEffect(() => {
        fetchCoupons()
    }, [fetchCoupons])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    function openCreate() {
        setForm({ ...EMPTY_FORM })
        setFormError('')
        setModalOpen(true)
    }

    function updateForm(field, value) {
        setForm((f) => ({ ...f, [field]: value }))
    }

    async function handleSubmit(e) {
        e.preventDefault()
        setSaving(true)
        setFormError('')

        try {
            const { data: res } = await api.post('/admin/coupons', {
                ...form,
                min_order: form.min_order || null,
                usage_limit: form.usage_limit || null,
                expires_at: form.expires_at || null,
            })
            setToast(res.message)
            setModalOpen(false)
            fetchCoupons()
        } catch (err) {
            setFormError(extractErrors(err, 'Unable to create coupon.'))
        } finally {
            setSaving(false)
        }
    }

    async function handleToggle(coupon) {
        try {
            const { data: res } = await api.patch(`/admin/coupons/${coupon.id}/toggle`)
            setToast(res.message)
            fetchCoupons()
        } catch {
            setToast('Unable to update coupon.')
        }
    }

    async function handleDelete(coupon) {
        if (!window.confirm(`Delete coupon "${coupon.code}"? This cannot be undone.`)) return
        try {
            const { data: res } = await api.delete(`/admin/coupons/${coupon.id}`)
            setToast(res.message)
            fetchCoupons()
        } catch {
            setToast('Unable to delete coupon.')
        }
    }

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Coupons</h1>
                <button type="button" onClick={openCreate} className="btn btn-primary">
                    <Plus size={18} /> Add Coupon
                </button>
            </div>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="relative min-w-[200px] flex-1">
                    <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        className="input !py-2 pl-9"
                        placeholder="Search coupon codes..."
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
                    <TicketPercent size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No coupons found</p>
                    <button type="button" onClick={openCreate} className="btn btn-primary mt-2">Add your first coupon</button>
                </div>
            ) : (
                <div className="card overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                                <tr>
                                    <th className="px-5 py-3">Code</th>
                                    <th className="px-5 py-3">Discount</th>
                                    <th className="px-5 py-3">Min Order</th>
                                    <th className="px-5 py-3">Usage</th>
                                    <th className="px-5 py-3">Expires</th>
                                    <th className="px-5 py-3">Status</th>
                                    <th className="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                                {data.data.map((coupon) => (
                                    <tr key={coupon.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                        <td className="px-5 py-3 font-mono font-bold uppercase text-brand-900 dark:text-white">{coupon.code}</td>
                                        <td className="px-5 py-3 font-semibold text-brand-900 dark:text-white">
                                            {coupon.type === 'percentage' ? `${coupon.value}%` : formatPrice(coupon.value)}
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{coupon.min_order ? formatPrice(coupon.min_order) : '—'}</td>
                                        <td className="px-5 py-3 text-slate-500">
                                            {coupon.used_count}
                                            {coupon.usage_limit ? ` / ${coupon.usage_limit}` : ''}
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{coupon.expires_at ? formatDate(coupon.expires_at) : '—'}</td>
                                        <td className="px-5 py-3">
                                            <span className={`badge ${coupon.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-slate-100 text-slate-500 dark:bg-brand-800 dark:text-slate-400'}`}>
                                                {coupon.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </td>
                                        <td className="px-5 py-3">
                                            <div className="flex justify-end gap-1">
                                                <button
                                                    type="button"
                                                    onClick={() => handleToggle(coupon)}
                                                    className={`rounded-lg p-2 hover:bg-brand-50 dark:hover:bg-brand-800 ${coupon.is_active ? 'text-slate-500 hover:text-amber-600' : 'text-emerald-500 hover:text-emerald-600'}`}
                                                    aria-label={coupon.is_active ? 'Deactivate' : 'Activate'}
                                                >
                                                    <Power size={16} />
                                                </button>
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(coupon)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                                    aria-label={`Delete ${coupon.code}`}
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

            {modalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={() => setModalOpen(false)} />
                    <div className="relative max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white shadow-2xl dark:bg-brand-900">
                        <div className="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4 dark:border-brand-800 dark:bg-brand-900">
                            <h2 className="text-lg font-bold text-brand-900 dark:text-white">Add Coupon</h2>
                            <button
                                type="button"
                                onClick={() => setModalOpen(false)}
                                className="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-brand-800"
                                aria-label="Close"
                            >
                                <X size={20} />
                            </button>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-4 p-6">
                            {formError && (
                                <div className="rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                                    {formError}
                                </div>
                            )}

                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Coupon Code</label>
                                <input
                                    className="input font-mono uppercase"
                                    required
                                    value={form.code}
                                    onChange={(e) => updateForm('code', e.target.value.toUpperCase())}
                                    placeholder="SUMMER20"
                                />
                            </div>

                            <div className="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                                    <select className="input" value={form.type} onChange={(e) => updateForm('type', e.target.value)}>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Value</label>
                                    <input
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        className="input"
                                        required
                                        value={form.value}
                                        onChange={(e) => updateForm('value', e.target.value)}
                                        placeholder={form.type === 'percentage' ? '20' : '10.00'}
                                    />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Min Order ({getCurrencySymbol()})</label>
                                    <input
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        className="input"
                                        value={form.min_order}
                                        onChange={(e) => updateForm('min_order', e.target.value)}
                                        placeholder="Optional"
                                    />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Usage Limit</label>
                                    <input
                                        type="number"
                                        min="1"
                                        step="1"
                                        className="input"
                                        value={form.usage_limit}
                                        onChange={(e) => updateForm('usage_limit', e.target.value)}
                                        placeholder="Unlimited"
                                    />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Expires At</label>
                                    <input
                                        type="date"
                                        className="input"
                                        value={form.expires_at}
                                        onChange={(e) => updateForm('expires_at', e.target.value)}
                                    />
                                </div>
                                <div className="flex items-end">
                                    <label className="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                                        <input
                                            type="checkbox"
                                            checked={form.is_active}
                                            onChange={(e) => updateForm('is_active', e.target.checked)}
                                            className="h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500"
                                        />
                                        Active immediately
                                    </label>
                                </div>
                            </div>

                            <div className="flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-brand-800">
                                <button type="button" onClick={() => setModalOpen(false)} className="btn btn-outline">
                                    Cancel
                                </button>
                                <button type="submit" disabled={saving} className="btn btn-primary">
                                    {saving && <Loader2 size={16} className="animate-spin" />}
                                    Create Coupon
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    )
}
