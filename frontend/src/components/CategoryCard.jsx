import { Link } from 'react-router-dom'
import { ArrowRight } from 'lucide-react'

const CATEGORY_ICONS = [
    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=400&q=60',
    'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=400&q=60',
    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=60',
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=400&q=60',
    'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=400&q=60',
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=400&q=60',
]

export default function CategoryCard({ category, index = 0 }) {
    const image = CATEGORY_ICONS[index % CATEGORY_ICONS.length]

    return (
        <Link
            to={`/shop?category=${category.slug}`}
            className="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-brand-800 dark:bg-brand-900"
        >
            <div className="aspect-[4/3] overflow-hidden">
                <img
                    src={image}
                    alt={category.name}
                    loading="lazy"
                    className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
            </div>
            <div className="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/40 to-transparent" />
            <div className="absolute inset-x-0 bottom-0 p-4">
                <h3 className="font-bold text-white">{category.name}</h3>
                <div className="mt-1 flex items-center justify-between">
                    <span className="text-xs text-slate-300">{category.products_count} products</span>
                    <span className="inline-flex items-center gap-1 text-xs font-semibold text-sky-300 group-hover:text-sky-200">
                        Shop now <ArrowRight size={12} />
                    </span>
                </div>
            </div>
        </Link>
    )
}
