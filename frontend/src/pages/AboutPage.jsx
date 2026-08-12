import { Link } from 'react-router-dom'
import { Zap, ShieldCheck, Package, Headphones } from 'lucide-react'

export default function AboutPage() {
    return (
        <div className="mx-auto max-w-7xl px-4 py-14 sm:px-6">
            <div className="mb-12 max-w-3xl">
                <h1 className="text-4xl font-extrabold text-brand-900 dark:text-white">About PulseTrade</h1>
                <p className="mt-4 text-lg leading-relaxed text-slate-600 dark:text-slate-300">
                    PulseTrade is your premium destination for the latest tech. We curate high-performance laptops, smartphones,
                    audio gear, wearables and accessories so you can upgrade your everyday with confidence.
                </p>
            </div>

            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {[
                    { icon: Zap, title: 'Quality First', text: 'Every product is hand-picked and quality checked.' },
                    { icon: Package, title: 'Curated Selection', text: 'We stock only gear worth your money.' },
                    { icon: Headphones, title: 'Fast Delivery', text: 'Orders ship within 24 hours, tracked end-to-end.' },
                    { icon: ShieldCheck, title: 'Expert Support', text: 'Real humans, ready to help 24/7.' },
                ].map(({ icon: Icon, title, text }) => (
                    <div key={title} className="card p-6">
                        <Icon size={28} className="text-sky-500" />
                        <h3 className="mt-3 font-bold text-brand-900 dark:text-white">{title}</h3>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">{text}</p>
                    </div>
                ))}
            </div>

            <div className="mt-14 rounded-3xl bg-brand-950 px-6 py-12 text-center dark:bg-brand-900">
                <h2 className="text-2xl font-extrabold text-white sm:text-3xl">Ready to upgrade?</h2>
                <p className="mx-auto mt-2 max-w-md text-slate-400">Explore our curated catalog and find your next favorite gadget.</p>
                <Link to="/shop" className="btn btn-accent mt-6">Shop Now</Link>
            </div>
        </div>
    )
}
