import { Link } from 'react-router-dom'
import { ShoppingCart } from 'lucide-react'
import { getImageUrl } from '../utils/image'
import { formatPrice, stockLabel, STOCK_STYLES } from '../utils/format'
import { useCart } from '../context/CartContext'
import StarRating from './StarRating'

export default function ProductCard({ product }) {
    const { addItem } = useCart()
    const image = getImageUrl(product)
    const finalPrice = product.final_price ?? product.price
    const hasDiscount = product.has_discount || (product.sale_price && product.sale_price < product.price)

    return (
        <div className="group card overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-brand-900/10">
            <Link to={`/product/${product.slug}`} className="relative block aspect-square overflow-hidden bg-slate-100 dark:bg-brand-800">
                <img
                    src={image}
                    alt={product.name}
                    loading="lazy"
                    className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
                {hasDiscount && (
                    <span className="badge absolute left-3 top-3 bg-rose-500 text-white">
                        -{Math.round((1 - product.sale_price / product.price) * 100)}%
                    </span>
                )}
                <span className={`badge absolute right-3 top-3 ${STOCK_STYLES[product.stock_status]}`}>
                    {stockLabel(product.stock_status)}
                </span>
            </Link>

            <div className="p-4">
                {product.category && (
                    <Link
                        to={`/shop?category=${product.category.slug}`}
                        className="text-xs font-medium uppercase tracking-wide text-sky-600 dark:text-sky-400"
                    >
                        {product.category.name}
                    </Link>
                )}
                <Link to={`/product/${product.slug}`} className="mt-1 block">
                    <h3 className="line-clamp-2 font-semibold text-brand-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-300">
                        {product.name}
                    </h3>
                </Link>

                <div className="mt-2 flex items-center gap-2">
                    <StarRating rating={Number(product.reviews_avg_rating || product.average_rating || 0)} size={14} />
                    {product.reviews_count > 0 && (
                        <span className="text-xs text-slate-400">({product.reviews_count})</span>
                    )}
                </div>

                <div className="mt-3 flex items-end justify-between">
                    <div className="flex items-baseline gap-2">
                        <span className="text-lg font-bold text-brand-900 dark:text-white">
                            {formatPrice(finalPrice)}
                        </span>
                        {hasDiscount && (
                            <span className="text-sm text-slate-400 line-through">{formatPrice(product.price)}</span>
                        )}
                    </div>
                    <button
                        type="button"
                        onClick={() => addItem(product)}
                        disabled={product.stock <= 0}
                        className="btn btn-primary !px-3 !py-2"
                        aria-label={`Add ${product.name} to cart`}
                    >
                        <ShoppingCart size={16} />
                    </button>
                </div>
            </div>
        </div>
    )
}
