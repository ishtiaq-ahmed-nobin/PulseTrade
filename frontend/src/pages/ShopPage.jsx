import { useCallback, useEffect, useRef, useState } from 'react'
import { useSearchParams } from 'react-router-dom'
import { Search, SlidersHorizontal, X, ChevronLeft, ChevronRight, Package } from 'lucide-react'
import api, { extractErrors } from '../services/api'
import ProductCard from '../components/ProductCard'
import Loader from '../components/Loader'
import { formatPrice } from '../utils/format'

const SORT_OPTIONS = [
    { value: 'newest', label: 'Newest' },
    { value: 'price_asc', label: 'Price: Low to High' },
    { value: 'price_desc', label: 'Price: High to Low' },
    { value: 'rating', label: 'Top Rated' },
    { value: 'name', label: 'Name: A-Z' },
]

export default function ShopPage() {
    const [searchParams, setSearchParams] = useSearchParams()
    const [data, setData] = useState(null)
    const [categories, setCategories] = useState([])
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState('')
    const [priceRange, setPriceRange] = useState([0, 2000])
    const priceTimer = useRef(null)

    const q = searchParams.get('q') || ''
    const category = searchParams.get('category') || ''
    const sort = searchParams.get('sort') || 'newest'
    const page = Number(searchParams.get('page') || 1)

    const fetchProducts = useCallback(() => {
        setLoading(true)
        setError('')
        const params = { page }
        if (q) params.q = q
        if (category) params.category = category
        if (sort) params.sort = sort
        if (priceRange[0] > 0) params.min_price = priceRange[0]
        if (priceRange[1] < 2000) params.max_price = priceRange[1]

        api.get('/products', { params })
            .then(({ data }) => setData(data))
            .catch((err) => setError(extractErrors(err, 'Failed to load products.')))
            .finally(() => setLoading(false))
    }, [q, category, sort, page, priceRange])

    useEffect(() => {
        api.get('/categories')
            .then(({ data }) => setCategories(data.categories))
            .catch(() => setCategories([]))
    }, [])

    useEffect(() => {
        fetchProducts()
    }, [fetchProducts])

    function updateParams(next) {
        const params = new URLSearchParams(searchParams)
        for (const [key, value] of Object.entries(next)) {
            if (value === '' || value === null || value === undefined) params.delete(key)
            else params.set(key, value)
        }
        if (!('page' in next)) params.delete('page')
        setSearchParams(params)
    }

    function handlePriceChange([min, max]) {
        setPriceRange([min, max])
        clearTimeout(priceTimer.current)
        priceTimer.current = setTimeout(() => {
            updateParams({
                min_price: min > 0 ? min : '',
                max_price: max < 2000 ? max : '',
            })
        }, 500)
    }

    function resetFilters() {
        setPriceRange([0, 2000])
        setSearchParams({})
    }

    const hasActiveFilters = Boolean(q || category || sort !== 'newest' || priceRange[0] > 0 || priceRange[1] < 2000)

    return (
        <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <div className="mb-8">
                <h1 className="text-3xl font-extrabold text-brand-900 dark:text-white">Shop</h1>
                <p className="mt-1 text-slate-500 dark:text-slate-400">
                    {data ? `${data.total} products found` : 'Browse our catalog'}
                </p>
            </div>

            <div className="grid gap-8 lg:grid-cols-[260px_1fr]">
                {/* Sidebar */}
                <aside className="space-y-6">
                    <div className="card p-5">
                        <div className="mb-4 flex items-center justify-between">
                            <h2 className="flex items-center gap-2 font-bold text-brand-900 dark:text-white">
                                <SlidersHorizontal size={18} className="text-sky-500" /> Filters
                            </h2>
                            {hasActiveFilters && (
                                <button
                                    type="button"
                                    onClick={resetFilters}
                                    className="flex items-center gap-1 text-xs font-semibold text-rose-500 hover:text-rose-400"
                                >
                                    <X size={14} /> Reset
                                </button>
                            )}
                        </div>

                        <div className="mb-5">
                            <div className="relative">
                                <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input
                                    type="search"
                                    defaultValue={q}
                                    onKeyDown={(e) => {
                                        if (e.key === 'Enter') updateParams({ q: e.target.value })
                                    }}
                                    onBlur={(e) => updateParams({ q: e.target.value })}
                                    placeholder="Search..."
                                    className="input !py-2 pl-9"
                                />
                            </div>
                        </div>

                        <div className="mb-5">
                            <h3 className="mb-2 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Categories</h3>
                            <div className="space-y-1.5">
                                <button
                                    type="button"
                                    onClick={() => updateParams({ category: '' })}
                                    className={`block w-full rounded-lg px-3 py-1.5 text-left text-sm transition-colors ${
                                        !category
                                            ? 'bg-brand-50 font-semibold text-brand-700 dark:bg-brand-800 dark:text-sky-400'
                                            : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-brand-800'
                                    }`}
                                >
                                    All Categories
                                </button>
                                {categories.map((cat) => (
                                    <button
                                        key={cat.id}
                                        type="button"
                                        onClick={() => updateParams({ category: cat.slug })}
                                        className={`block w-full rounded-lg px-3 py-1.5 text-left text-sm transition-colors ${
                                            category === cat.slug
                                                ? 'bg-brand-50 font-semibold text-brand-700 dark:bg-brand-800 dark:text-sky-400'
                                                : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-brand-800'
                                        }`}
                                    >
                                        {cat.name}
                                        <span className="ml-1 text-xs text-slate-400">({cat.products_count})</span>
                                    </button>
                                ))}
                            </div>
                        </div>

                        <div>
                            <h3 className="mb-2 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Price Range</h3>
                            <div className="mb-2 flex items-center justify-between text-sm font-semibold text-brand-900 dark:text-white">
                                <span>{formatPrice(priceRange[0])}</span>
                                <span>{formatPrice(priceRange[1])}</span>
                            </div>
                            <input
                                type="range"
                                min="0"
                                max="2000"
                                step="10"
                                value={priceRange[0]}
                                onChange={(e) => handlePriceChange([Number(e.target.value), priceRange[1]])}
                                className="w-full accent-brand-700"
                            />
                            <input
                                type="range"
                                min="0"
                                max="2000"
                                step="10"
                                value={priceRange[1]}
                                onChange={(e) => handlePriceChange([priceRange[0], Number(e.target.value)])}
                                className="w-full accent-brand-700"
                            />
                        </div>
                    </div>
                </aside>

                {/* Product grid */}
                <div>
                    <div className="mb-6 flex items-center justify-between">
                        <p className="text-sm text-slate-500 dark:text-slate-400">
                            Showing {data ? Math.min(data.current_page * data.per_page, data.total) : 0} of {data?.total ?? 0}
                        </p>
                        <select
                            value={sort}
                            onChange={(e) => updateParams({ sort: e.target.value })}
                            className="input !w-auto !py-2"
                        >
                            {SORT_OPTIONS.map((opt) => (
                                <option key={opt.value} value={opt.value}>
                                    {opt.label}
                                </option>
                            ))}
                        </select>
                    </div>

                    {loading ? (
                        <Loader />
                    ) : error ? (
                        <div className="card p-10 text-center text-rose-600">{error}</div>
                    ) : data?.data?.length === 0 ? (
                        <div className="card flex flex-col items-center justify-center gap-3 p-16 text-center">
                            <Package size={48} className="text-slate-300 dark:text-brand-700" />
                            <p className="font-semibold text-brand-900 dark:text-white">No products found</p>
                            <p className="text-sm text-slate-500">Try adjusting your filters or search.</p>
                            <button type="button" onClick={resetFilters} className="btn btn-outline mt-2">
                                Clear Filters
                            </button>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                            {data?.data?.map((product) => (
                                <ProductCard key={product.id} product={product} />
                            ))}
                        </div>
                    )}

                    {data && data.last_page > 1 && (
                        <div className="mt-8 flex items-center justify-center gap-2">
                            <button
                                type="button"
                                disabled={data.current_page <= 1}
                                onClick={() => updateParams({ page: data.current_page - 1 })}
                                className="btn btn-outline !p-2"
                                aria-label="Previous page"
                            >
                                <ChevronLeft size={18} />
                            </button>
                            {Array.from({ length: data.last_page }, (_, i) => i + 1)
                                .filter((p) => Math.abs(p - data.current_page) <= 2 || p === 1 || p === data.last_page)
                                .map((p, idx, arr) => (
                                    <span key={p} className="flex items-center gap-2">
                                        {idx > 0 && arr[idx - 1] !== p - 1 && <span className="text-slate-400">…</span>}
                                        <button
                                            type="button"
                                            onClick={() => updateParams({ page: p })}
                                            className={`h-10 w-10 rounded-lg text-sm font-semibold transition-colors ${
                                                p === data.current_page
                                                    ? 'bg-brand-900 text-white dark:bg-brand-500'
                                                    : 'border border-slate-300 text-slate-600 hover:border-brand-500 hover:text-brand-700 dark:border-brand-700 dark:text-slate-300'
                                            }`}
                                        >
                                            {p}
                                        </button>
                                    </span>
                                ))}
                            <button
                                type="button"
                                disabled={data.current_page >= data.last_page}
                                onClick={() => updateParams({ page: data.current_page + 1 })}
                                className="btn btn-outline !p-2"
                                aria-label="Next page"
                            >
                                <ChevronRight size={18} />
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </div>
    )
}
