import { useEffect, useRef, useState } from 'react'
import { Link, NavLink, Outlet, useLocation, useNavigate } from 'react-router-dom'
import {
    Zap,
    LayoutDashboard,
    Package,
    Tags,
    ShoppingBag,
    Sun,
    Moon,
    LogOut,
    Menu,
    X,
    Store,
    Boxes,
    BarChart3,
    TicketPercent,
    Mail,
    Users,
    Star,
    Settings as SettingsIcon,
} from 'lucide-react'
import { useTheme } from '../context/ThemeContext'
import { useAuth } from '../context/AuthContext'

const NAV_GROUPS = [
    {
        label: 'Orders & Fulfillment',
        items: [{ label: 'Orders', to: '/admin/orders', icon: ShoppingBag }],
    },
    {
        label: 'Inventory & Stock',
        items: [
            { label: 'Products', to: '/admin/products', icon: Package },
            { label: 'Inventory', to: '/admin/inventory', icon: Boxes },
            { label: 'Categories', to: '/admin/categories', icon: Tags },
        ],
    },
    {
        label: 'Analytics & Reports',
        items: [{ label: 'Sales Report', to: '/admin/reports', icon: BarChart3 }],
    },
    {
        label: 'Marketing & Promotions',
        items: [
            { label: 'Coupons', to: '/admin/coupons', icon: TicketPercent },
            { label: 'Subscribers', to: '/admin/subscribers', icon: Mail },
        ],
    },
    {
        label: 'User Management',
        items: [
            { label: 'Customers', to: '/admin/customers', icon: Users },
            { label: 'Reviews', to: '/admin/reviews', icon: Star },
        ],
    },
    {
        label: 'System & Settings',
        items: [{ label: 'Settings', to: '/admin/settings', icon: SettingsIcon }],
    },
]

export default function AdminLayout() {
    const { theme, toggleTheme } = useTheme()
    const { user, logout } = useAuth()
    const [sidebarOpen, setSidebarOpen] = useState(false)
    const sidebarRef = useRef(null)
    const location = useLocation()
    const navigate = useNavigate()

    useEffect(() => {
        setSidebarOpen(false)
    }, [location])

    useEffect(() => {
        function onClick(e) {
            if (sidebarRef.current && !sidebarRef.current.contains(e.target)) {
                setSidebarOpen(false)
            }
        }
        document.addEventListener('mousedown', onClick)
        return () => document.removeEventListener('mousedown', onClick)
    }, [])

    async function handleLogout() {
        await logout()
        navigate('/')
    }

    const sidebar = (
        <div className="flex h-full flex-col bg-brand-950 text-slate-300">
            <div className="flex items-center justify-between border-b border-white/10 px-5 py-4">
                <Link to="/" className="flex items-center gap-2">
                    <span className="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white">
                        <Zap size={18} />
                    </span>
                    <span className="text-lg font-extrabold tracking-tight text-white">
                        Pulse<span className="text-sky-400">Trade</span>
                    </span>
                </Link>
                <button
                    type="button"
                    className="rounded-lg p-1.5 text-slate-400 hover:text-white lg:hidden"
                    onClick={() => setSidebarOpen(false)}
                    aria-label="Close sidebar"
                >
                    <X size={18} />
                </button>
            </div>

            <nav className="flex-1 space-y-1 overflow-y-auto px-3 py-5">
                <p className="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-slate-500">Admin Panel</p>
                <NavLink
                    to="/admin"
                    end
                    className={({ isActive }) =>
                        `flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors ${
                            isActive ? 'bg-sky-500/20 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white'
                        }`
                    }
                >
                    <LayoutDashboard size={18} /> Dashboard
                </NavLink>

                {NAV_GROUPS.map((group) => (
                    <div key={group.label}>
                        <p className="mt-5 mb-1.5 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            {group.label}
                        </p>
                        {group.items.map(({ label, to, icon: Icon }) => (
                            <NavLink
                                key={to}
                                to={to}
                                className={({ isActive }) =>
                                    `flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors ${
                                        isActive
                                            ? 'bg-sky-500/20 text-white'
                                            : 'text-slate-400 hover:bg-white/5 hover:text-white'
                                    }`
                                }
                            >
                                <Icon size={18} /> {label}
                            </NavLink>
                        ))}
                    </div>
                ))}
            </nav>

            <div className="border-t border-white/10 p-4">
                <Link to="/" className="mb-3 flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-400 hover:text-white">
                    <Store size={16} /> Back to Store
                </Link>
                <div className="flex items-center gap-2">
                    <span className="flex h-8 w-8 items-center justify-center rounded-full bg-sky-500 text-sm font-bold text-white">
                        {user?.name?.charAt(0)?.toUpperCase()}
                    </span>
                    <div className="min-w-0 flex-1">
                        <p className="truncate text-sm font-semibold text-white">{user?.name}</p>
                        <p className="text-xs text-slate-500">{user?.email}</p>
                    </div>
                </div>
            </div>
        </div>
    )

    return (
        <div className="flex min-h-screen bg-slate-100 dark:bg-brand-950">
            {sidebarOpen && (
                <div className="fixed inset-0 z-40 bg-black/50 lg:hidden" onClick={() => setSidebarOpen(false)} />
            )}
            <aside
                ref={sidebarRef}
                className={`fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 lg:static lg:translate-x-0 ${
                    sidebarOpen ? 'translate-x-0' : '-translate-x-full'
                }`}
            >
                {sidebar}
            </aside>

            <div className="flex min-w-0 flex-1 flex-col">
                <header className="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white/90 px-4 py-3 backdrop-blur dark:border-brand-800 dark:bg-brand-900/90 sm:px-6">
                    <div className="flex items-center gap-3">
                        <button
                            type="button"
                            className="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden dark:text-slate-300 dark:hover:bg-brand-800"
                            onClick={() => setSidebarOpen(true)}
                            aria-label="Open sidebar"
                        >
                            <Menu size={20} />
                        </button>
                        <h1 className="text-lg font-bold text-brand-900 dark:text-white">PulseTrade Admin</h1>
                    </div>
                    <div className="flex items-center gap-2">
                        <button
                            type="button"
                            onClick={toggleTheme}
                            aria-label="Toggle theme"
                            className="rounded-lg p-2 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-brand-800"
                        >
                            {theme === 'dark' ? <Sun size={18} /> : <Moon size={18} />}
                        </button>
                        <button
                            type="button"
                            onClick={handleLogout}
                            className="btn btn-outline !px-3 !py-2"
                        >
                            <LogOut size={16} /> Logout
                        </button>
                    </div>
                </header>

                <main className="flex-1 p-4 sm:p-6">
                    <Outlet />
                </main>
            </div>
        </div>
    )
}
