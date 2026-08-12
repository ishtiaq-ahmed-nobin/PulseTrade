import { useEffect, useRef, useState } from 'react'
import { Link, NavLink, useLocation, useNavigate } from 'react-router-dom'
import {
    Menu,
    X,
    Search,
    Sun,
    Moon,
    ShoppingCart,
    User,
    LayoutDashboard,
    Package,
    LogOut,
    ChevronDown,
    Zap,
} from 'lucide-react'
import { useTheme } from '../context/ThemeContext'
import { useAuth } from '../context/AuthContext'
import { useCart } from '../context/CartContext'

const NAV_LINKS = [
    { label: 'Home', to: '/' },
    { label: 'Shop', to: '/shop' },
    { label: 'About', to: '/about' },
    { label: 'Contact', to: '/contact' },
]

export default function Navbar() {
    const { theme, toggleTheme } = useTheme()
    const { user, isAuthenticated, isAdmin, logout } = useAuth()
    const { count, openDrawer } = useCart()
    const [mobileOpen, setMobileOpen] = useState(false)
    const [userOpen, setUserOpen] = useState(false)
    const [query, setQuery] = useState('')
    const userMenuRef = useRef(null)
    const navigate = useNavigate()
    const location = useLocation()

    useEffect(() => {
        setMobileOpen(false)
        setUserOpen(false)
    }, [location])

    useEffect(() => {
        function onClick(e) {
            if (userMenuRef.current && !userMenuRef.current.contains(e.target)) {
                setUserOpen(false)
            }
        }
        document.addEventListener('mousedown', onClick)
        return () => document.removeEventListener('mousedown', onClick)
    }, [])

    function handleSearch(e) {
        e.preventDefault()
        navigate(query.trim() ? `/shop?q=${encodeURIComponent(query.trim())}` : '/shop')
    }

    async function handleLogout() {
        await logout()
        navigate('/')
    }

    return (
        <header className="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur dark:border-brand-800 dark:bg-brand-950/90">
            <nav className="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6">
                <Link to="/" className="flex items-center gap-2">
                    <span className="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-brand-700 to-brand-950 text-white">
                        <Zap size={18} />
                    </span>
                    <span className="text-xl font-extrabold tracking-tight text-brand-900 dark:text-white">
                        Pulse<span className="text-sky-500">Trade</span>
                    </span>
                </Link>

                <div className="hidden flex-1 items-center gap-1 lg:flex">
                    {NAV_LINKS.map((link) => (
                        <NavLink
                            key={link.to}
                            to={link.to}
                            className={({ isActive }) =>
                                `rounded-lg px-3 py-2 text-sm font-medium transition-colors ${
                                    isActive
                                        ? 'text-brand-700 dark:text-brand-300'
                                        : 'text-slate-600 hover:text-brand-700 dark:text-slate-300 dark:hover:text-brand-300'
                                }`
                            }
                        >
                            {link.label}
                        </NavLink>
                    ))}
                </div>

                <form onSubmit={handleSearch} className="hidden flex-1 max-w-md md:block">
                    <div className="relative">
                        <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input
                            type="search"
                            value={query}
                            onChange={(e) => setQuery(e.target.value)}
                            placeholder="Search products..."
                            className="input !py-2 pl-9"
                        />
                    </div>
                </form>

                <div className="flex items-center gap-1.5">
                    <button
                        type="button"
                        onClick={toggleTheme}
                        aria-label="Toggle theme"
                        className="rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-brand-700 dark:text-slate-300 dark:hover:bg-brand-800"
                    >
                        {theme === 'dark' ? <Sun size={20} /> : <Moon size={20} />}
                    </button>

                    <button
                        type="button"
                        onClick={openDrawer}
                        aria-label="Open cart"
                        className="relative rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-brand-700 dark:text-slate-300 dark:hover:bg-brand-800"
                    >
                        <ShoppingCart size={20} />
                        {count > 0 && (
                            <span className="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-sky-500 px-1 text-xs font-bold text-white">
                                {count}
                            </span>
                        )}
                    </button>

                    {isAuthenticated ? (
                        <div className="relative" ref={userMenuRef}>
                            <button
                                type="button"
                                onClick={() => setUserOpen((v) => !v)}
                                className="flex items-center gap-1.5 rounded-lg p-1.5 transition-colors hover:bg-slate-100 dark:hover:bg-brand-800"
                            >
                                <span className="flex h-8 w-8 items-center justify-center rounded-full bg-brand-900 text-sm font-bold text-white dark:bg-brand-500">
                                    {user.name.charAt(0).toUpperCase()}
                                </span>
                                <ChevronDown size={16} className="text-slate-400" />
                            </button>

                            {userOpen && (
                                <div className="absolute right-0 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg dark:border-brand-700 dark:bg-brand-900">
                                    <div className="border-b border-slate-100 px-4 py-3 dark:border-brand-800">
                                        <p className="truncate text-sm font-semibold text-brand-900 dark:text-white">{user.name}</p>
                                        <p className="truncate text-xs text-slate-500 dark:text-slate-400">{user.email}</p>
                                    </div>
                                    <div className="p-1.5">
                                        <Link
                                            to="/account"
                                            className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-brand-800"
                                        >
                                            <User size={16} /> My Account
                                        </Link>
                                        {isAdmin && (
                                            <Link
                                                to="/admin"
                                                className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-brand-800"
                                            >
                                                <LayoutDashboard size={16} /> Admin Panel
                                            </Link>
                                        )}
                                        <button
                                            type="button"
                                            onClick={handleLogout}
                                            className="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-900/20"
                                        >
                                            <LogOut size={16} /> Sign out
                                        </button>
                                    </div>
                                </div>
                            )}
                        </div>
                    ) : (
                        <Link to="/login" className="hidden sm:inline-flex btn btn-primary !py-2">
                            Sign In
                        </Link>
                    )}

                    <button
                        type="button"
                        className="rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 lg:hidden dark:text-slate-300 dark:hover:bg-brand-800"
                        onClick={() => setMobileOpen((v) => !v)}
                        aria-label="Toggle menu"
                    >
                        {mobileOpen ? <X size={22} /> : <Menu size={22} />}
                    </button>
                </div>
            </nav>

            {mobileOpen && (
                <div className="border-t border-slate-200 px-4 pb-4 pt-2 lg:hidden dark:border-brand-800">
                    <form onSubmit={handleSearch} className="mb-3 md:hidden">
                        <div className="relative">
                            <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                            <input
                                type="search"
                                value={query}
                                onChange={(e) => setQuery(e.target.value)}
                                placeholder="Search products..."
                                className="input !py-2 pl-9"
                            />
                        </div>
                    </form>
                    <div className="flex flex-col gap-1">
                        {NAV_LINKS.map((link) => (
                            <NavLink
                                key={link.to}
                                to={link.to}
                                className={({ isActive }) =>
                                    `rounded-lg px-3 py-2.5 text-sm font-medium ${
                                        isActive
                                            ? 'bg-brand-50 text-brand-700 dark:bg-brand-800 dark:text-brand-300'
                                            : 'text-slate-600 dark:text-slate-300'
                                    }`
                                }
                            >
                                {link.label}
                            </NavLink>
                        ))}
                        {!isAuthenticated && (
                            <Link to="/login" className="mt-1 inline-flex btn btn-primary">
                                Sign In
                            </Link>
                        )}
                    </div>
                </div>
            )}
        </header>
    )
}
