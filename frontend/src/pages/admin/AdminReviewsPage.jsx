import { useCallback, useEffect, useState } from 'react'
import {
    Trash2,
    ChevronLeft,
    ChevronRight,
    Star,
    StarHalf,
    MessageSquare,
} from 'lucide-react'
import api from '../../services/api'
import { getImageUrl } from '../../utils/image'
import { formatDateTime } from '../../utils/format'
import Loader from '../../components/Loader'

export default function AdminReviewsPage() {
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [rating, setRating] = useState('')
    const [page, setPage] = useState(1)
    const [toast, setToast] = useState('')

    const fetchReviews = useCallback(() => {
        setLoading(true)
        const params = { page }
        if (rating) params.rating = rating

        api.get('/admin/reviews', { params })
            .then(({ data }) => setData(data))
            .catch(() => {})
            .finally(() => setLoading(false))
    }, [rating, page])

    useEffect(() => {
        fetchReviews()
    }, [fetchReviews])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    async function handleDelete(review) {
        if (!window.confirm('Delete this review? This cannot be undone.')) return
        try {
            const { data: res } = await api.delete(`/admin/reviews/${review.id}`)
            setToast(res.message)
            fetchReviews()
        } catch {
            setToast('Unable to delete review.')
        }
    }

    function renderStars(value) {
        const stars = []
        const full = Math.floor(value)
        const hasHalf = value - full >= 0.5
        for (let i = 1; i <= 5; i += 1) {
            if (i <= full) {
                stars.push(<Star key={i} size={14} className="fill-amber-400 text-amber-400" />)
            } else if (i === full + 1 && hasHalf) {
                stars.push(<StarHalf key={i} size={14} className="fill-amber-400 text-amber-400" />)
            } else {
                stars.push(<Star key={i} size={14} className="text-slate-300 dark:text-brand-700" />)
            }
        }
        return stars
    }

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Reviews</h1>
            </div>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <select className="input !w-auto !py-2" value={rating} onChange={(e) => { setRating(e.target.value); setPage(1) }}>
                    <option value="">All Ratings</option>
                    {[5, 4, 3, 2, 1].map((r) => (
                        <option key={r} value={r}>{r} Stars</option>
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
            ) : data?.data?.length === 0 ? (
                <div className="card flex flex-col items-center gap-3 p-14 text-center">
                    <MessageSquare size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No reviews found</p>
                </div>
            ) : (
                <div className="space-y-4">
                    {data.data.map((review) => (
                        <div key={review.id} className="card p-5">
                            <div className="flex flex-wrap items-start justify-between gap-4">
                                <div className="flex items-start gap-3">
                                    <img src={getImageUrl(review.product)} alt={review.product?.name} className="h-12 w-12 rounded-lg object-cover" />
                                    <div>
                                        <p className="font-semibold text-brand-900 dark:text-white">{review.product?.name}</p>
                                        <p className="text-xs text-slate-400">#{review.product_id}</p>
                                        <div className="mt-1 flex items-center gap-1.5">
                                            <div className="flex">{renderStars(review.rating)}</div>
                                            <span className="text-xs font-semibold text-slate-500 dark:text-slate-400">{review.rating}.0</span>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => handleDelete(review)}
                                    className="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                    aria-label="Delete review"
                                >
                                    <Trash2 size={16} />
                                </button>
                            </div>
                            <p className="mt-4 text-sm text-slate-600 dark:text-slate-300">{review.comment || '—'}</p>
                            <p className="mt-3 text-xs text-slate-400">
                                By {review.user?.name || 'Deleted user'} · {formatDateTime(review.created_at)}
                            </p>
                        </div>
                    ))}

                    {data && data.last_page > 1 && (
                        <div className="card flex items-center justify-between px-5 py-3">
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
