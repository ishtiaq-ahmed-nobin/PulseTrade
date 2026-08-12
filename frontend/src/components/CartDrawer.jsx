import { Link, useNavigate } from 'react-router-dom'
import { X, Plus, Minus, Trash2, ShoppingBag, ArrowRight } from 'lucide-react'
import { useCart } from '../context/CartContext'
import { formatPrice } from '../utils/format'
import { getImageUrl } from '../utils/image'

export default function CartDrawer() {
    const { items, drawerOpen, closeDrawer, updateQuantity, removeItem, subtotal, count } = useCart()
    const navigate = useNavigate()

    function goTo(path) {
        closeDrawer()
        navigate(path)
    }

    if (!drawerOpen) return null

    return (
        <div className="fixed inset-0 z-50">
            <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={closeDrawer} />

            <aside className="absolute right-0 top-0 flex h-full w-full max-w-md flex-col bg-white shadow-2xl dark:bg-brand-900">
                <div className="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-brand-800">
                    <h2 className="flex items-center gap-2 text-lg font-bold text-brand-900 dark:text-white">
                        <ShoppingBag size={20} className="text-sky-500" />
                        Your Cart
                        {count > 0 && <span className="badge bg-brand-100 text-brand-800 dark:bg-brand-800 dark:text-brand-200">{count} items</span>}
                    </h2>
                    <button
                        type="button"
                        onClick={closeDrawer}
                        className="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-brand-800"
                        aria-label="Close cart"
                    >
                        <X size={20} />
                    </button>
                </div>

                {items.length === 0 ? (
                    <div className="flex flex-1 flex-col items-center justify-center gap-4 px-6 text-center">
                        <ShoppingBag size={56} className="text-slate-300 dark:text-brand-700" />
                        <p className="font-semibold text-brand-900 dark:text-white">Your cart is empty</p>
                        <p className="text-sm text-slate-500 dark:text-slate-400">Explore our catalog and find something you love.</p>
                        <button type="button" onClick={() => goTo('/shop')} className="btn btn-primary">
                            Start Shopping
                        </button>
                    </div>
                ) : (
                    <>
                        <div className="flex-1 space-y-4 overflow-y-auto px-5 py-4">
                            {items.map((item) => (
                                <div key={item.product_id} className="flex gap-3 rounded-xl border border-slate-200 p-3 dark:border-brand-800">
                                    <img
                                        src={item.product.image_url || getImageUrl(item.product)}
                                        alt={item.product.name}
                                        className="h-20 w-20 shrink-0 rounded-lg object-cover"
                                    />
                                    <div className="flex flex-1 flex-col">
                                        <Link
                                            to={`/product/${item.product.slug}`}
                                            onClick={closeDrawer}
                                            className="text-sm font-semibold text-brand-900 hover:text-brand-600 dark:text-white"
                                        >
                                            {item.product.name}
                                        </Link>
                                        <span className="text-sm font-bold text-brand-900 dark:text-white">
                                            {formatPrice(item.product.final_price ?? item.product.price)}
                                        </span>
                                        <div className="mt-auto flex items-center justify-between">
                                            <div className="flex items-center rounded-lg border border-slate-200 dark:border-brand-700">
                                                <button
                                                    type="button"
                                                    onClick={() => updateQuantity(item.product_id, item.quantity - 1)}
                                                    className="p-1.5 text-slate-500 hover:text-brand-700 dark:text-slate-400"
                                                    aria-label="Decrease quantity"
                                                >
                                                    <Minus size={14} />
                                                </button>
                                                <span className="w-8 text-center text-sm font-semibold">{item.quantity}</span>
                                                <button
                                                    type="button"
                                                    onClick={() => updateQuantity(item.product_id, item.quantity + 1)}
                                                    className="p-1.5 text-slate-500 hover:text-brand-700 dark:text-slate-400"
                                                    aria-label="Increase quantity"
                                                >
                                                    <Plus size={14} />
                                                </button>
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() => removeItem(item.product_id)}
                                                className="rounded-lg p-1.5 text-slate-400 hover:text-rose-500"
                                                aria-label="Remove item"
                                            >
                                                <Trash2 size={16} />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        <div className="border-t border-slate-200 px-5 py-4 dark:border-brand-800">
                            <div className="mb-4 flex items-center justify-between">
                                <span className="text-sm text-slate-500 dark:text-slate-400">Subtotal</span>
                                <span className="text-xl font-bold text-brand-900 dark:text-white">{formatPrice(subtotal)}</span>
                            </div>
                            <div className="grid grid-cols-2 gap-3">
                                <button type="button" onClick={() => goTo('/cart')} className="btn btn-outline">
                                    View Cart
                                </button>
                                <button type="button" onClick={() => goTo('/checkout')} className="btn btn-primary">
                                    Checkout <ArrowRight size={16} />
                                </button>
                            </div>
                        </div>
                    </>
                )}
            </aside>
        </div>
    )
}
