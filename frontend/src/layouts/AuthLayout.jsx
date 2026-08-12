import { Link, Outlet } from 'react-router-dom'
import { Zap } from 'lucide-react'

export default function AuthLayout({ children }) {
    return (
        <div className="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-4 py-10">
            <div className="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-sky-500/20 blur-3xl" />
            <div className="pointer-events-none absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-brand-400/20 blur-3xl" />

            <div className="relative w-full max-w-md">
                <Link to="/" className="mb-6 flex items-center justify-center gap-2">
                    <span className="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white backdrop-blur">
                        <Zap size={20} />
                    </span>
                    <span className="text-2xl font-extrabold tracking-tight text-white">
                        Pulse<span className="text-sky-400">Trade</span>
                    </span>
                </Link>

                <div className="rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-xl dark:bg-brand-900/95">
                    {children ?? <Outlet />}
                </div>

                <p className="mt-6 text-center text-xs text-slate-300">
                    &copy; {new Date().getFullYear()} PulseTrade — Premium Tech Electronics
                </p>
            </div>
        </div>
    )
}
