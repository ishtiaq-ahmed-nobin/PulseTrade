import { Link } from 'react-router-dom'
import { Zap, Mail, Phone, MapPin, Facebook, Twitter, Instagram, Youtube } from 'lucide-react'

export default function Footer() {
    return (
        <footer className="border-t border-slate-200 bg-brand-950 text-slate-300 dark:border-brand-900">
            <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6">
                <div className="grid gap-10 md:grid-cols-4">
                    <div className="space-y-4">
                        <Link to="/" className="flex items-center gap-2">
                            <span className="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white">
                                <Zap size={18} />
                            </span>
                            <span className="text-xl font-extrabold tracking-tight text-white">
                                Pulse<span className="text-sky-400">Trade</span>
                            </span>
                        </Link>
                        <p className="text-sm leading-relaxed text-slate-400">
                            Premium tech electronics — laptops, phones, audio gear, wearables and accessories. Curated for enthusiasts.
                        </p>
                        <div className="flex gap-3">
                            {[Facebook, Twitter, Instagram, Youtube].map((Icon, i) => (
                                <a
                                    key={i}
                                    href="#"
                                    className="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-300 transition-colors hover:bg-sky-500 hover:text-white"
                                >
                                    <Icon size={16} />
                                </a>
                            ))}
                        </div>
                    </div>

                    <div>
                        <h4 className="mb-4 text-sm font-bold uppercase tracking-wide text-white">Shop</h4>
                        <ul className="space-y-2 text-sm">
                            <li><Link to="/shop" className="hover:text-sky-400">All Products</Link></li>
                            <li><Link to="/shop?sort=price_asc" className="hover:text-sky-400">Best Deals</Link></li>
                            <li><Link to="/shop?sort=rating" className="hover:text-sky-400">Top Rated</Link></li>
                            <li><Link to="/shop" className="hover:text-sky-400">New Arrivals</Link></li>
                        </ul>
                    </div>

                    <div>
                        <h4 className="mb-4 text-sm font-bold uppercase tracking-wide text-white">Company</h4>
                        <ul className="space-y-2 text-sm">
                            <li><Link to="/about" className="hover:text-sky-400">About Us</Link></li>
                            <li><Link to="/contact" className="hover:text-sky-400">Contact</Link></li>
                            <li><Link to="/faq" className="hover:text-sky-400">FAQ</Link></li>
                            <li><Link to="/blog" className="hover:text-sky-400">Blog</Link></li>
                        </ul>
                    </div>

                    <div>
                        <h4 className="mb-4 text-sm font-bold uppercase tracking-wide text-white">Contact</h4>
                        <ul className="space-y-3 text-sm text-slate-400">
                            <li className="flex items-start gap-2">
                                <MapPin size={16} className="mt-0.5 shrink-0 text-sky-400" />
                                100 Tech Park Blvd, San Francisco, CA
                            </li>
                            <li className="flex items-center gap-2">
                                <Phone size={16} className="shrink-0 text-sky-400" />
                                +1 (800) 555-9876
                            </li>
                            <li className="flex items-center gap-2">
                                <Mail size={16} className="shrink-0 text-sky-400" />
                                hello@pulsetrade.com
                            </li>
                        </ul>
                    </div>
                </div>

                <div className="mt-10 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-slate-500 sm:flex-row">
                    <p>&copy; {new Date().getFullYear()} PulseTrade. All rights reserved.</p>
                    <p>Premium Tech Electronics Store</p>
                </div>
            </div>
        </footer>
    )
}
