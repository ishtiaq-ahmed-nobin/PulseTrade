import { Link, useNavigate } from 'react-router-dom'
import { Plus, Minus, Trash2, ShoppingBag, ArrowRight } from 'lucide-react'
import { useCart } from '../context/CartContext'
import { getImageUrl } from '../utils/image'
import { formatPrice } from '../utils/format'

export default function CartPage() {
    const { items, updateQuantity, removeItem, subtotal, count } = useCart()
    const navigate = useNavigate()

    if (items.length === 0) {
        return (
            <div className="mx-auto flex max-w-7xl flex-col items-center justify-center gap-4 px-4 py-24 text-center">
                <ShoppingBag size={64} className="text-slate-300 dark:text-brand-700" />
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Your cart is empty</h1>
                <p className="text-slate-500 dark:text-slate-400">Looks like you haven't added anything yet.</p>
                <button type="button" onClick={() => navigate('/shop')} className="btn btn-primary mt-2">
                    Start Shopping
                </button>
            </div>
        )
    }

    return (
        <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <h1 className="mb-8 text-3xl font-extrabold text-brand-900 dark:text-white">
                Shopping Cart <span className="text-lg font-medium text-slate-400">({count} items)</span>
            </h1>

            <div className="grid gap-8 lg:grid-cols-[1fr_360px]">
                <div className="space-y-4">
                    {items.map((item) => (
                        <div key={item.product_id} className="card flex gap-4 p-4">
                            <Link to={`/product/${item.product.slug}`} className="shrink-0">
                                <img
                                    src={item.product.image_url || getImageUrl(item.product)}
                                    alt={item.product.name}
                                    className="h-24 w-24 rounded-xl object-cover"
                                />
                            </Link>
                            <div className="flex flex-1 flex-col justify-between">
                                <div className="flex items-start justify-between gap-4">
                                    <div>
                                        <Link
                                            to={`/product/${item.product.slug}`}
                                            className="font-semibold text-brand-900 hover:text-brand-600 dark:text-white"
                                        >
                                            {item.product.name}
                                        </Link>
                                        <p className="mt-1 text-sm font-bold text-brand-900 dark:text-white">
                                            {formatPrice(item.product.final_price ?? item.product.price)}
                                        </p>
                                    </div>
                                    <button
                                        type="button"
                                        onClick={() => removeItem(item.product_id)}
                                        className="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                        aria-label="Remove item"
                                    >
                                        <Trash2 size={18} />
                                    </button>
                                </div>
                                <div className="flex items-center justify-between">
                                    <div className="flex items-center rounded-lg border border-slate-200 dark:border-brand-700">
                                        <button
                                            type="button"
                                            onClick={() => updateQuantity(item.product_id, item.quantity - 1)}
                                            className="p-2 text-slate-500 hover:text-brand-700 dark:text-slate-400"
                                            aria-label="Decrease"
                                        >
                                            <Minus size={15} />
                                        </button>
                                        <span className="w-10 text-center font-semibold text-brand-900 dark:text-white">{item.quantity}</span>
                                        <button
                                            type="button"
                                            onClick={() => updateQuantity(item.product_id, item.quantity + 1)}
                                            className="p-2 text-slate-500 hover:text-brand-700 dark:text-slate-400"
                                            aria-label="Increase"
                                        >
                                            <Plus size={15} />
                                        </button>
                                    </div>
                                    <span className="font-bold text-brand-900 dark:text-white">
                                        {formatPrice((item.product.final_price ?? item.product.price) * item.quantity)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="card h-fit p-6">
                    <h2 className="mb-4 text-lg font-bold text-brand-900 dark:text-white">Order Summary</h2>
                    <div className="space-y-2 text-sm">
                        <div className="flex justify-between text-slate-600 dark:text-slate-300">
                            <span>Subtotal</span>
                            <span className="font-semibold text-brand-900 dark:text-white">{formatPrice(subtotal)}</span>
                        </div>
                        <div className="flex justify-between text-slate-600 dark:text-slate-300">
                            <span>Shipping</span>
                            <span className="text-xs text-slate-400">Calculated at checkout</span>
                        </div>
                    </div>
                    <div className="my-4 border-t border-slate-200 dark:border-brand-800" />
                    <div className="flex justify-between text-base font-bold text-brand-900 dark:text-white">
                        <span>Total</span>
                        <span>{formatPrice(subtotal)}</span>
                    </div>
                    <button type="button" onClick={() => navigate('/checkout')} className="btn btn-primary mt-6 w-full !py-3">
                        Proceed to Checkout <ArrowRight size={18} />
                    </button>
                    <Link to="/shop" className="mt-3 block text-center text-sm font-semibold text-brand-700 hover:text-brand-500 dark:text-sky-400">
                        Continue Shopping
                    </Link>
                </div>
            </div>
        </div>
    )
}
