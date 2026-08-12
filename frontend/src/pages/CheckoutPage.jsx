import { useEffect, useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { ShieldCheck, CreditCard, Banknote, Tag, Loader2, CheckCircle2, AlertCircle } from 'lucide-react'
import api, { extractErrors } from '../services/api'
import { useCart } from '../context/CartContext'
import { useAuth } from '../context/AuthContext'
import { formatPrice } from '../utils/format'
import { getImageUrl } from '../utils/image'

const EMPTY_FORM = {
    name: '',
    email: '',
    address: '',
    city: '',
    postal_code: '',
    phone: '',
    payment_method: 'cod',
}

export default function CheckoutPage() {
    const { items, subtotal, clearCart } = useCart()
    const { user, isAuthenticated } = useAuth()
    const navigate = useNavigate()

    const [form, setForm] = useState({ ...EMPTY_FORM })
    const [shipping, setShipping] = useState({ free_threshold: 100, cost: 9.99 })
    const [coupon, setCoupon] = useState('')
    const [discount, setDiscount] = useState(0)
    const [couponCode, setCouponCode] = useState(null)
    const [couponError, setCouponError] = useState('')
    const [couponSuccess, setCouponSuccess] = useState('')
    const [errors, setErrors] = useState({})
    const [error, setError] = useState('')
    const [success, setSuccess] = useState('')
    const [placing, setPlacing] = useState(false)
    const [processingCard, setProcessingCard] = useState(false)

    useEffect(() => {
        api.get('/settings/public')
            .then(({ data }) => {
                setShipping({
                    free_threshold: Number(data.settings.free_shipping_threshold || 100),
                    cost: Number(data.settings.shipping_cost || 9.99),
                })
            })
            .catch(() => {})

        if (user) {
            setForm((f) => ({
                ...f,
                name: f.name || user.name || '',
                email: f.email || user.email || '',
                phone: f.phone || user.phone || '',
                address: f.address || user.address || '',
            }))
        }
    }, [user])

    useEffect(() => {
        if (items.length === 0 && !success) {
            navigate('/cart', { replace: true })
        }
    }, [items.length, success, navigate])

    if (items.length === 0 && !success) {
        return null
    }

    const shippingCost = subtotal >= shipping.free_threshold ? 0 : shipping.cost
    const total = Math.max(0, subtotal + shippingCost - discount)

    async function handleCoupon(e) {
        e.preventDefault()
        setCouponError('')
        setCouponSuccess('')
        try {
            const { data } = await api.post('/coupon/validate', {
                coupon_code: coupon,
                subtotal,
            })
            setDiscount(data.discount)
            setCouponCode(data.coupon_code)
            setCouponSuccess(`Coupon applied! You saved ${formatPrice(data.discount)}.`)
        } catch (err) {
            setDiscount(0)
            setCouponCode(null)
            setCouponError(extractErrors(err, 'Invalid coupon code.'))
        }
    }

    function update(field, value) {
        setForm((f) => ({ ...f, [field]: value }))
    }

    async function handleSubmit(e) {
        e.preventDefault()
        setErrors({})
        setError('')
        setSuccess('')

        if (form.payment_method === 'card') {
            setProcessingCard(true)
            await new Promise((r) => setTimeout(r, 1500))
        }
        setProcessingCard(false)
        setPlacing(true)

        try {
            const payload = {
                ...form,
                coupon_code: couponCode,
                items: items.map((item) => ({
                    product_id: item.product_id,
                    quantity: item.quantity,
                })),
            }
            const { data } = await api.post('/checkout', payload)
            clearCart()
            setSuccess(data.message)
            setPlacing(false)
        } catch (err) {
            const data = err.response?.data
            if (data?.errors) setErrors(data.errors)
            else setError(extractErrors(err, 'Unable to place your order.'))
            setPlacing(false)
        }
    }

    if (success) {
        return (
            <div className="mx-auto flex max-w-lg flex-col items-center gap-4 px-4 py-24 text-center">
                <span className="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                    <CheckCircle2 size={40} className="text-emerald-600 dark:text-emerald-400" />
                </span>
                <h1 className="text-2xl font-extrabold text-brand-900 dark:text-white">Order Placed!</h1>
                <p className="text-slate-500 dark:text-slate-400">{success}</p>
                {!isAuthenticated && (
                    <p className="rounded-lg bg-brand-50 px-4 py-2 text-sm text-brand-800 dark:bg-brand-800 dark:text-brand-200">
                        Create an account to track your orders.
                    </p>
                )}
                <div className="mt-4 flex gap-3">
                    <Link to="/shop" className="btn btn-outline">Continue Shopping</Link>
                    {isAuthenticated && (
                        <Link to="/account" className="btn btn-primary">View My Orders</Link>
                    )}
                </div>
            </div>
        )
    }

    return (
        <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <h1 className="mb-8 text-3xl font-extrabold text-brand-900 dark:text-white">Checkout</h1>

            <div className="grid gap-8 lg:grid-cols-[1fr_380px]">
                <form onSubmit={handleSubmit} className="space-y-6">
                    {error && (
                        <div className="flex items-start gap-2 rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                            <AlertCircle size={16} className="mt-0.5 shrink-0" />
                            <span>{error}</span>
                        </div>
                    )}

                    <section className="card p-6">
                        <h2 className="mb-4 text-lg font-bold text-brand-900 dark:text-white">Contact & Shipping</h2>
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="sm:col-span-2">
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
                                <input className="input" value={form.name} onChange={(e) => update('name', e.target.value)} required />
                                {errors.name && <p className="mt-1 text-xs text-rose-500">{errors.name[0]}</p>}
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                                <input type="email" className="input" value={form.email} onChange={(e) => update('email', e.target.value)} required />
                                {errors.email && <p className="mt-1 text-xs text-rose-500">{errors.email[0]}</p>}
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
                                <input type="tel" className="input" value={form.phone} onChange={(e) => update('phone', e.target.value)} required />
                                {errors.phone && <p className="mt-1 text-xs text-rose-500">{errors.phone[0]}</p>}
                            </div>
                            <div className="sm:col-span-2">
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Street Address</label>
                                <input className="input" value={form.address} onChange={(e) => update('address', e.target.value)} required />
                                {errors.address && <p className="mt-1 text-xs text-rose-500">{errors.address[0]}</p>}
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">City</label>
                                <input className="input" value={form.city} onChange={(e) => update('city', e.target.value)} required />
                                {errors.city && <p className="mt-1 text-xs text-rose-500">{errors.city[0]}</p>}
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Postal Code</label>
                                <input className="input" value={form.postal_code} onChange={(e) => update('postal_code', e.target.value)} required />
                                {errors.postal_code && <p className="mt-1 text-xs text-rose-500">{errors.postal_code[0]}</p>}
                            </div>
                        </div>
                    </section>

                    <section className="card p-6">
                        <h2 className="mb-4 text-lg font-bold text-brand-900 dark:text-white">Payment Method</h2>
                        <div className="grid gap-3 sm:grid-cols-2">
                            <button
                                type="button"
                                onClick={() => update('payment_method', 'cod')}
                                className={`rounded-xl border-2 p-4 text-left transition-colors ${
                                    form.payment_method === 'cod'
                                        ? 'border-brand-600 bg-brand-50 dark:border-sky-400 dark:bg-brand-800'
                                        : 'border-slate-200 hover:border-slate-300 dark:border-brand-800'
                                }`}
                            >
                                <Banknote size={22} className="mb-2 text-brand-700 dark:text-sky-400" />
                                <p className="font-semibold text-brand-900 dark:text-white">Cash on Delivery</p>
                                <p className="text-xs text-slate-500">Pay when your order arrives</p>
                            </button>
                            <button
                                type="button"
                                onClick={() => update('payment_method', 'card')}
                                className={`rounded-xl border-2 p-4 text-left transition-colors ${
                                    form.payment_method === 'card'
                                        ? 'border-brand-600 bg-brand-50 dark:border-sky-400 dark:bg-brand-800'
                                        : 'border-slate-200 hover:border-slate-300 dark:border-brand-800'
                                }`}
                            >
                                <CreditCard size={22} className="mb-2 text-brand-700 dark:text-sky-400" />
                                <p className="font-semibold text-brand-900 dark:text-white">Pay with Card</p>
                                <p className="text-xs text-slate-500">Simulated secure payment</p>
                            </button>
                        </div>
                        {errors.payment_method && <p className="mt-1 text-xs text-rose-500">{errors.payment_method[0]}</p>}
                    </section>

                    <button type="submit" disabled={placing || processingCard} className="btn btn-primary w-full !py-3.5 text-base">
                        {(processingCard || placing) ? (
                            <>
                                <Loader2 size={18} className="animate-spin" />
                                {processingCard ? 'Processing payment...' : 'Placing order...'}
                            </>
                        ) : (
                            <>
                                <ShieldCheck size={18} /> Place Order — {formatPrice(total)}
                            </>
                        )}
                    </button>
                </form>

                {/* Order summary */}
                <div className="card h-fit p-6">
                    <h2 className="mb-4 text-lg font-bold text-brand-900 dark:text-white">Order Summary</h2>
                    <div className="max-h-72 space-y-3 overflow-y-auto">
                        {items.map((item) => (
                            <div key={item.product_id} className="flex items-center gap-3">
                                <img
                                    src={item.product.image_url || getImageUrl(item.product)}
                                    alt={item.product.name}
                                    className="h-14 w-14 rounded-lg object-cover"
                                />
                                <div className="min-w-0 flex-1">
                                    <p className="truncate text-sm font-semibold text-brand-900 dark:text-white">{item.product.name}</p>
                                    <p className="text-xs text-slate-500">Qty {item.quantity}</p>
                                </div>
                                <span className="text-sm font-bold text-brand-900 dark:text-white">
                                    {formatPrice((item.product.final_price ?? item.product.price) * item.quantity)}
                                </span>
                            </div>
                        ))}
                    </div>

                    <form onSubmit={handleCoupon} className="mt-4">
                        <div className="flex gap-2">
                            <div className="relative flex-1">
                                <Tag size={15} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input
                                    className="input !py-2 pl-9"
                                    placeholder="Coupon code"
                                    value={coupon}
                                    onChange={(e) => setCoupon(e.target.value)}
                                />
                            </div>
                            <button type="submit" className="btn btn-outline !px-4 !py-2">Apply</button>
                        </div>
                        {couponSuccess && <p className="mt-2 text-xs font-semibold text-emerald-600">{couponSuccess}</p>}
                        {couponError && <p className="mt-2 text-xs font-semibold text-rose-500">{couponError}</p>}
                    </form>

                    <div className="mt-4 space-y-2 border-t border-slate-200 pt-4 text-sm dark:border-brand-800">
                        <div className="flex justify-between text-slate-600 dark:text-slate-300">
                            <span>Subtotal</span>
                            <span>{formatPrice(subtotal)}</span>
                        </div>
                        <div className="flex justify-between text-slate-600 dark:text-slate-300">
                            <span>Shipping</span>
                            <span className={shippingCost === 0 ? 'font-semibold text-emerald-600' : ''}>
                                {shippingCost === 0 ? 'Free' : formatPrice(shippingCost)}
                            </span>
                        </div>
                        {discount > 0 && (
                            <div className="flex justify-between text-emerald-600">
                                <span>Discount</span>
                                <span>-{formatPrice(discount)}</span>
                            </div>
                        )}
                    </div>
                    <div className="mt-3 flex justify-between border-t border-slate-200 pt-3 text-lg font-bold text-brand-900 dark:border-brand-800 dark:text-white">
                        <span>Total</span>
                        <span>{formatPrice(total)}</span>
                    </div>
                </div>
            </div>
        </div>
    )
}
