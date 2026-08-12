import { useEffect, useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import {
    ChevronRight,
    ShoppingCart,
    Minus,
    Plus,
    ShieldCheck,
    Truck,
    RotateCcw,
    AlertCircle,
    Star,
    Send,
} from 'lucide-react'
import api, { extractErrors } from '../services/api'
import { useAuth } from '../context/AuthContext'
import { useCart } from '../context/CartContext'
import { getImageUrl } from '../utils/image'
import { formatPrice, formatDate, stockLabel, STOCK_STYLES } from '../utils/format'
import StarRating from '../components/StarRating'
import ProductSlider from '../components/Slider'
import Loader from '../components/Loader'

export default function ProductDetailPage() {
    const { slug } = useParams()
    const { isAuthenticated } = useAuth()
    const { addItem } = useCart()
    const [data, setData] = useState(null)
    const [error, setError] = useState('')
    const [loading, setLoading] = useState(true)
    const [activeImage, setActiveImage] = useState(0)
    const [quantity, setQuantity] = useState(1)
    const [tab, setTab] = useState('description')
    const [reviewForm, setReviewForm] = useState({ rating: 5, comment: '' })
    const [reviewError, setReviewError] = useState('')
    const [reviewSuccess, setReviewSuccess] = useState('')
    const [adding, setAdding] = useState(false)

    useEffect(() => {
        setLoading(true)
        setError('')
        setActiveImage(0)
        setQuantity(1)
        setTab('description')
        api.get(`/products/${slug}`)
            .then(({ data }) => setData(data))
            .catch((err) => setError(extractErrors(err, 'Product not found.')))
            .finally(() => setLoading(false))
    }, [slug])

    if (loading) return <Loader full />
    if (error || !data) {
        return (
            <div className="mx-auto max-w-7xl px-4 py-24 text-center">
                <p className="text-lg font-semibold text-rose-600">{error || 'Product not found.'}</p>
                <Link to="/shop" className="btn btn-primary mt-6">Back to Shop</Link>
            </div>
        )
    }

    const { product, gallery, reviews, related } = data

    async function handleAddToCart() {
        setAdding(true)
        try {
            await addItem(product, quantity)
        } finally {
            setAdding(false)
        }
    }

    async function handleReview(e) {
        e.preventDefault()
        setReviewError('')
        setReviewSuccess('')
        try {
            const { data: res } = await api.post(`/products/${product.id}/reviews`, reviewForm)
            setReviewSuccess(res.message)
            setReviewForm({ rating: 5, comment: '' })
            const { data: updated } = await api.get(`/products/${slug}`)
            setData(updated)
        } catch (err) {
            setReviewError(extractErrors(err, 'Unable to submit review.'))
        }
    }

    const hasDiscount = product.has_discount
    const finalPrice = product.final_price ?? product.price

    return (
        <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <nav className="mb-6 flex items-center gap-1 text-sm text-slate-500 dark:text-slate-400">
                <Link to="/" className="hover:text-brand-700 dark:hover:text-sky-400">Home</Link>
                <ChevronRight size={14} />
                <Link to="/shop" className="hover:text-brand-700 dark:hover:text-sky-400">Shop</Link>
                {product.category && (
                    <>
                        <ChevronRight size={14} />
                        <Link
                            to={`/shop?category=${product.category.slug}`}
                            className="hover:text-brand-700 dark:hover:text-sky-400"
                        >
                            {product.category.name}
                        </Link>
                    </>
                )}
                <ChevronRight size={14} />
                <span className="truncate text-slate-700 dark:text-slate-300">{product.name}</span>
            </nav>

            <div className="grid gap-10 lg:grid-cols-2">
                {/* Gallery */}
                <div>
                    <div className="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 dark:border-brand-800 dark:bg-brand-800">
                        <img
                            src={gallery[activeImage] || getImageUrl(product)}
                            alt={product.name}
                            className="aspect-square w-full object-cover"
                        />
                    </div>
                    {gallery.length > 1 && (
                        <div className="mt-3 flex gap-3 overflow-x-auto pb-1">
                            {gallery.map((img, i) => (
                                <button
                                    key={i}
                                    type="button"
                                    onClick={() => setActiveImage(i)}
                                    className={`shrink-0 overflow-hidden rounded-xl border-2 transition-colors ${
                                        i === activeImage ? 'border-brand-600' : 'border-transparent opacity-70 hover:opacity-100'
                                    }`}
                                >
                                    <img src={img} alt="" className="h-20 w-20 object-cover" />
                                </button>
                            ))}
                        </div>
                    )}
                </div>

                {/* Info */}
                <div>
                    <span className={`badge ${STOCK_STYLES[product.stock_status]}`}>{stockLabel(product.stock_status)}</span>
                    <h1 className="mt-3 text-3xl font-extrabold text-brand-900 dark:text-white">{product.name}</h1>

                    <div className="mt-3 flex items-center gap-3">
                        <StarRating rating={data.average_rating} size={18} />
                        <span className="text-sm text-slate-500">{data.average_rating} rating</span>
                        <span className="h-4 w-px bg-slate-300 dark:bg-brand-700" />
                        <span className="text-sm text-slate-500">{data.review_count} reviews</span>
                    </div>

                    <div className="mt-5 flex items-baseline gap-3">
                        <span className="text-4xl font-extrabold text-brand-900 dark:text-white">{formatPrice(finalPrice)}</span>
                        {hasDiscount && (
                            <>
                                <span className="text-xl text-slate-400 line-through">{formatPrice(product.price)}</span>
                                <span className="badge bg-rose-500 text-white">
                                    Save {formatPrice(product.price - product.sale_price)}
                                </span>
                            </>
                        )}
                    </div>

                    <p className="mt-5 leading-relaxed text-slate-600 dark:text-slate-300">{product.description}</p>

                    <div className="mt-6 flex flex-wrap items-center gap-4">
                        <div className="flex items-center rounded-xl border border-slate-300 dark:border-brand-700">
                            <button
                                type="button"
                                onClick={() => setQuantity((q) => Math.max(1, q - 1))}
                                className="p-3 text-slate-500 hover:text-brand-700 dark:text-slate-400"
                                aria-label="Decrease quantity"
                            >
                                <Minus size={16} />
                            </button>
                            <span className="w-12 text-center text-lg font-bold text-brand-900 dark:text-white">{quantity}</span>
                            <button
                                type="button"
                                onClick={() => setQuantity((q) => Math.min(product.stock, q + 1))}
                                className="p-3 text-slate-500 hover:text-brand-700 dark:text-slate-400"
                                aria-label="Increase quantity"
                            >
                                <Plus size={16} />
                            </button>
                        </div>
                        <button
                            type="button"
                            onClick={handleAddToCart}
                            disabled={product.stock <= 0 || adding}
                            className="btn btn-primary flex-1 !py-3 sm:flex-none sm:px-10"
                        >
                            <ShoppingCart size={18} />
                            {product.stock <= 0 ? 'Out of Stock' : adding ? 'Adding...' : 'Add to Cart'}
                        </button>
                    </div>

                    <div className="mt-6 grid gap-3 sm:grid-cols-3">
                        {[
                            { icon: Truck, label: 'Free Shipping', sub: 'On orders over $100' },
                            { icon: ShieldCheck, label: '2-Year Warranty', sub: 'Official coverage' },
                            { icon: RotateCcw, label: 'Easy Returns', sub: '30-day return policy' },
                        ].map(({ icon: Icon, label, sub }) => (
                            <div key={label} className="rounded-xl border border-slate-200 p-3 dark:border-brand-800">
                                <Icon size={20} className="text-sky-500" />
                                <p className="mt-2 text-sm font-bold text-brand-900 dark:text-white">{label}</p>
                                <p className="text-xs text-slate-500">{sub}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* Tabs */}
            <div className="mt-12">
                <div className="flex gap-1 border-b border-slate-200 dark:border-brand-800">
                    {[
                        { id: 'description', label: 'Description' },
                        { id: 'reviews', label: `Reviews (${data.review_count})` },
                    ].map((t) => (
                        <button
                            key={t.id}
                            type="button"
                            onClick={() => setTab(t.id)}
                            className={`border-b-2 px-4 py-3 text-sm font-semibold transition-colors ${
                                tab === t.id
                                    ? 'border-brand-700 text-brand-700 dark:border-sky-400 dark:text-sky-400'
                                    : 'border-transparent text-slate-500 hover:text-brand-700 dark:text-slate-400'
                            }`}
                        >
                            {t.label}
                        </button>
                    ))}
                </div>

                <div className="py-8">
                    {tab === 'description' ? (
                        <p className="max-w-3xl leading-relaxed text-slate-600 dark:text-slate-300">{product.description}</p>
                    ) : (
                        <div className="grid gap-10 lg:grid-cols-[1fr_380px]">
                            <div className="space-y-5">
                                {reviews.length === 0 ? (
                                    <p className="text-slate-500 dark:text-slate-400">No reviews yet. Be the first to review this product!</p>
                                ) : (
                                    reviews.map((review) => (
                                        <div key={review.id} className="rounded-xl border border-slate-200 p-4 dark:border-brand-800">
                                            <div className="flex items-center justify-between">
                                                <div className="flex items-center gap-3">
                                                    <span className="flex h-10 w-10 items-center justify-center rounded-full bg-brand-100 font-bold text-brand-700 dark:bg-brand-800 dark:text-sky-400">
                                                        {review.user?.name?.charAt(0)?.toUpperCase()}
                                                    </span>
                                                    <div>
                                                        <p className="font-semibold text-brand-900 dark:text-white">{review.user?.name}</p>
                                                        <p className="text-xs text-slate-400">{formatDate(review.created_at)}</p>
                                                    </div>
                                                </div>
                                                <StarRating rating={review.rating} size={14} />
                                            </div>
                                            {review.comment && <p className="mt-3 text-sm text-slate-600 dark:text-slate-300">{review.comment}</p>}
                                        </div>
                                    ))
                                )}
                            </div>

                            <div>
                                <h3 className="mb-3 font-bold text-brand-900 dark:text-white">Write a Review</h3>
                                {!isAuthenticated ? (
                                    <div className="card p-5 text-center text-sm text-slate-500 dark:text-slate-400">
                                        <Link to="/login" className="font-semibold text-brand-700 dark:text-sky-400">Sign in</Link> to write a review.
                                    </div>
                                ) : (
                                    <form onSubmit={handleReview} className="card space-y-4 p-5">
                                        {reviewSuccess && (
                                            <div className="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                                                {reviewSuccess}
                                            </div>
                                        )}
                                        {reviewError && (
                                            <div className="flex items-start gap-2 rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                                                <AlertCircle size={16} className="mt-0.5 shrink-0" />
                                                <span>{reviewError}</span>
                                            </div>
                                        )}
                                        <div>
                                            <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Rating</label>
                                            <div className="flex gap-1">
                                                {[1, 2, 3, 4, 5].map((star) => (
                                                    <button
                                                        key={star}
                                                        type="button"
                                                        onClick={() => setReviewForm({ ...reviewForm, rating: star })}
                                                        aria-label={`Rate ${star} stars`}
                                                    >
                                                        <Star
                                                            size={24}
                                                            className={
                                                                star <= reviewForm.rating
                                                                    ? 'fill-amber-400 text-amber-400'
                                                                    : 'fill-slate-200 text-slate-200 dark:fill-brand-800 dark:text-brand-800'
                                                            }
                                                        />
                                                    </button>
                                                ))}
                                            </div>
                                        </div>
                                        <div>
                                            <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Comment</label>
                                            <textarea
                                                rows={3}
                                                className="input"
                                                placeholder="Share your experience..."
                                                value={reviewForm.comment}
                                                onChange={(e) => setReviewForm({ ...reviewForm, comment: e.target.value })}
                                            />
                                        </div>
                                        <button type="submit" className="btn btn-primary w-full">
                                            <Send size={16} /> Submit Review
                                        </button>
                                    </form>
                                )}
                            </div>
                        </div>
                    )}
                </div>
            </div>

            {related?.length > 0 && (
                <section className="mt-8">
                    <h2 className="mb-8 text-2xl font-bold text-brand-900 dark:text-white">You May Also Like</h2>
                    <ProductSlider products={related} id="related" />
                </section>
            )}
        </div>
    )
}
