import { Link } from 'react-router-dom'
import { ArrowRight, Clock } from 'lucide-react'
import { formatDate } from '../utils/format'

const POSTS = [
    {
        slug: 'best-laptops-2026',
        title: 'The Best Laptops of 2026 for Work and Play',
        excerpt: 'From ultraportables to powerhouses — here are the laptops worth your money this year.',
        image: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
        date: '2026-08-01',
    },
    {
        slug: 'true-wireless-earbuds-guide',
        title: 'A Beginner\'s Guide to True Wireless Earbuds',
        excerpt: 'ANC, battery life, codecs — everything you need to pick the perfect pair.',
        image: 'https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=800&q=80',
        date: '2026-07-18',
    },
    {
        slug: 'smartwatch-vs-fitness-band',
        title: 'Smartwatch vs Fitness Band: Which Should You Buy?',
        excerpt: 'We break down the differences so you can choose the wearable that fits your lifestyle.',
        image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
        date: '2026-06-25',
    },
]

export default function BlogPage() {
    return (
        <div className="mx-auto max-w-7xl px-4 py-14 sm:px-6">
            <h1 className="mb-2 text-4xl font-extrabold text-brand-900 dark:text-white">PulseTrade Blog</h1>
            <p className="mb-10 text-slate-500 dark:text-slate-400">Guides, tips and the latest in tech.</p>

            <div className="grid gap-6 md:grid-cols-3">
                {POSTS.map((post) => (
                    <article key={post.slug} className="card group overflow-hidden">
                        <img src={post.image} alt={post.title} className="aspect-[16/10] w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div className="p-5">
                            <p className="flex items-center gap-1.5 text-xs text-slate-400">
                                <Clock size={12} /> {formatDate(post.date)}
                            </p>
                            <h2 className="mt-2 font-bold leading-snug text-brand-900 group-hover:text-brand-600 dark:text-white dark:group-hover:text-brand-300">
                                {post.title}
                            </h2>
                            <p className="mt-2 text-sm text-slate-500 dark:text-slate-400">{post.excerpt}</p>
                            <Link to="/blog" className="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sky-600 dark:text-sky-400">
                                Read more <ArrowRight size={14} />
                            </Link>
                        </div>
                    </article>
                ))}
            </div>
        </div>
    )
}
