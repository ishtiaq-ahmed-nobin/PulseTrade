import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import {
    ArrowRight,
    Truck,
    ShieldCheck,
    BadgeCheck,
    Headphones,
    Sparkles,
    Package,
    Mail,
    Send,
    Star,
} from 'lucide-react'
import api, { extractErrors } from '../services/api'
import ProductSlider from '../components/Slider'
import CategoryCard from '../components/CategoryCard'
import Loader from '../components/Loader'
import { formatPrice } from '../utils/format'

const TRUST_ITEMS = [
    { icon: Truck, title: 'Free Shipping', text: 'On orders over $100' },
    { icon: ShieldCheck, title: 'Secure Payment', text: '100% protected checkout' },
    { icon: BadgeCheck, title: 'Official Warranty', text: 'Up to 2 years coverage' },
    { icon: Headphones, title: '24/7 Support', text: 'We are always here' },
]

export default function HomePage() {
    const [data, setData] = useState(null)
    const [error, setError] = useState('')
    const [newsletter, setNewsletter] = useState({ email: '', status: '' })

    useEffect(() => {
        api.get('/home')
            .then(({ data }) => setData(data))
            .catch((err) => setError(extractErrors(err, 'Failed to load the store.')))
    }, [])

    async function handleNewsletter(e) {
        e.preventDefault()
        setNewsletter({ ...newsletter, status: 'success' })
    }

    if (error) {
        return (
            <div className="mx-auto max-w-7xl px-4 py-20 text-center">
                <p className="text-lg font-semibold text-rose-600">{error}</p>
            </div>
        )
    }

    if (!data) return <Loader full />

    return (
        <div>
            {/* Hero */}
            <section className="relative overflow-hidden bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800">
                <div className="pointer-events-none absolute -top-24 right-0 h-96 w-96 rounded-full bg-sky-500/20 blur-3xl" />
                <div className="pointer-events-none absolute bottom-0 left-0 h-80 w-80 rounded-full bg-brand-400/10 blur-3xl" />
                <div className="relative mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:py-24">
                    <div>
                        <span className="badge bg-white/10 text-sky-300">Premium Tech Electronics</span>
                        <h1 className="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Upgrade Your <span className="bg-gradient-to-r from-sky-400 to-sky-200 bg-clip-text text-transparent">Tech Game</span>
                        </h1>
                        <p className="mt-5 max-w-lg text-lg text-slate-300">
                            Discover the latest laptops, phones, audio gear, wearables and accessories — hand-picked for performance and style.
                        </p>
                        <div className="mt-8 flex flex-wrap gap-4">
                            <Link to="/shop" className="btn btn-accent">
                                Shop Now <ArrowRight size={18} />
                            </Link>
                            <Link to="/shop?sort=price_asc" className="btn border border-white/20 bg-white/5 text-white hover:bg-white/10">
                                <Sparkles size={18} /> Best Deals
                            </Link>
                        </div>
                        <div className="mt-8 flex items-center gap-6 text-sm text-slate-300">
                            <div className="flex items-center gap-1.5">
                                <Star size={16} className="fill-amber-400 text-amber-400" />
                                <span className="font-semibold text-white">4.8</span> rating
                            </div>
                            <span className="h-4 w-px bg-white/20" />
                            <span><span className="font-semibold text-white">10k+</span> happy customers</span>
                        </div>
                    </div>
                    <div className="relative hidden lg:block">
                        <img
                            src="https://images.unsplash.com/photo-1783743962099-2944190bae0e?auto=format&fit=crop&w=900&q=80"
                            alt="Premium electronics"
                            className="rounded-3xl border border-white/10 shadow-2xl"
                        />
                        <div className="absolute -bottom-5 -left-5 rounded-2xl border border-white/10 bg-white/95 p-4 shadow-xl backdrop-blur dark:bg-brand-900/95">
                            <p className="text-xs text-slate-500 dark:text-slate-400">Weekly Deal</p>
                            <p className="text-lg font-bold text-brand-900 dark:text-white">
                                Up to <span className="text-rose-500">30% off</span>
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Trust strip */}
            <section className="border-b border-slate-200 bg-white dark:border-brand-800 dark:bg-brand-900">
                <div className="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 sm:px-6 lg:grid-cols-4">
                    {TRUST_ITEMS.map(({ icon: Icon, title, text }) => (
                        <div key={title} className="flex items-center gap-3">
                            <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700 dark:bg-brand-800 dark:text-sky-400">
                                <Icon size={22} />
                            </span>
                            <div>
                                <p className="text-sm font-bold text-brand-900 dark:text-white">{title}</p>
                                <p className="text-xs text-slate-500 dark:text-slate-400">{text}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Featured categories */}
            <section className="mx-auto max-w-7xl px-4 py-14 sm:px-6">
                <div className="mb-8 flex items-end justify-between">
                    <div>
                        <h2 className="section-title">Shop by Category</h2>
                        <p className="mt-1 text-slate-500 dark:text-slate-400">Explore our curated collections</p>
                    </div>
                    <Link to="/shop" className="hidden items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-500 sm:flex dark:text-sky-400">
                        View all <ArrowRight size={16} />
                    </Link>
                </div>
                <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                    {data.categories.map((category, i) => (
                        <CategoryCard key={category.id} category={category} index={i} />
                    ))}
                </div>
            </section>

            {/* Featured products */}
            <section className="bg-slate-50 py-14 dark:bg-brand-900/40">
                <div className="mx-auto max-w-7xl px-4 sm:px-6">
                    <div className="mb-10 flex items-end justify-between">
                        <div>
                            <h2 className="section-title">Featured Products</h2>
                            <p className="mt-1 text-slate-500 dark:text-slate-400">Hand-picked tech you will love</p>
                        </div>
                        <Link to="/shop" className="hidden items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-500 sm:flex dark:text-sky-400">
                            View all <ArrowRight size={16} />
                        </Link>
                    </div>
                    <ProductSlider products={data.featured} id="featured" />
                </div>
            </section>

            {/* Promo banner */}
            <section className="mx-auto max-w-7xl px-4 py-14 sm:px-6">
                <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-800 to-brand-950 px-6 py-12 sm:px-12">
                    <div className="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-sky-500/20 blur-3xl" />
                    <div className="relative flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
                        <div>
                            <span className="badge bg-sky-500/20 text-sky-300">Limited Time</span>
                            <h2 className="mt-3 text-3xl font-extrabold text-white">Up to 30% Off Selected Gear</h2>
                            <p className="mt-2 max-w-md text-slate-300">
                                Grab premium laptops, audio and wearables at unbeatable prices before they are gone.
                            </p>
                        </div>
                        <Link to="/shop" className="btn btn-accent shrink-0">
                            Shop the Sale <ArrowRight size={18} />
                        </Link>
                    </div>
                </div>
            </section>

            {/* New arrivals */}
            <section className="mx-auto max-w-7xl px-4 pb-14 sm:px-6">
                <div className="mb-10 flex items-end justify-between">
                    <div>
                        <h2 className="section-title">New Arrivals</h2>
                        <p className="mt-1 text-slate-500 dark:text-slate-400">Fresh drops, straight from the warehouse</p>
                    </div>
                    <Link to="/shop" className="hidden items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-500 sm:flex dark:text-sky-400">
                        View all <ArrowRight size={16} />
                    </Link>
                </div>
                <ProductSlider products={data.new_arrivals} id="new-arrivals" />
            </section>

            {/* Newsletter */}
            <section className="border-t border-slate-200 bg-brand-950 py-14 dark:border-brand-800">
                <div className="mx-auto max-w-2xl px-4 text-center sm:px-6">
                    <span className="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-sky-400">
                        <Mail size={22} />
                    </span>
                    <h2 className="mt-4 text-2xl font-extrabold text-white sm:text-3xl">Get 10% Off Your First Order</h2>
                    <p className="mt-2 text-slate-400">
                        Subscribe to the PulseTrade newsletter for exclusive deals, new arrivals and tech tips.
                    </p>
                    {newsletter.status === 'success' ? (
                        <div className="mx-auto mt-6 flex max-w-md items-center justify-center gap-2 rounded-xl bg-emerald-500/15 px-4 py-3 text-emerald-300">
                            <CheckCircleIcon /> Thanks for subscribing! Check your inbox for the code.
                        </div>
                    ) : (
                        <form onSubmit={handleNewsletter} className="mx-auto mt-6 flex max-w-md gap-2">
                            <input
                                type="email"
                                required
                                className="input flex-1 !bg-white/10 !border-white/20 !text-white placeholder:!text-slate-400"
                                placeholder="Enter your email"
                                value={newsletter.email}
                                onChange={(e) => setNewsletter({ ...newsletter, email: e.target.value })}
                            />
                            <button type="submit" className="btn btn-accent shrink-0">
                                <Send size={16} /> Subscribe
                            </button>
                        </form>
                    )}
                </div>
            </section>
        </div>
    )
}

function CheckCircleIcon() {
    return <Package size={20} />
}
