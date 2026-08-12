import { useState } from 'react'
import { Link, useLocation, useNavigate } from 'react-router-dom'
import { Mail, Lock, Eye, EyeOff, LogIn, AlertCircle } from 'lucide-react'
import { useAuth, extractErrors } from '../context/AuthContext'

export default function LoginPage() {
    const { login } = useAuth()
    const navigate = useNavigate()
    const location = useLocation()
    const [form, setForm] = useState({ email: '', password: '', remember: false })
    const [showPassword, setShowPassword] = useState(false)
    const [errors, setErrors] = useState({})
    const [error, setError] = useState('')
    const [loading, setLoading] = useState(false)

    const from = location.state?.from || '/'

    async function handleSubmit(e) {
        e.preventDefault()
        setErrors({})
        setError('')
        setLoading(true)
        try {
            await login(form)
            navigate(from, { replace: true })
        } catch (err) {
            const data = err.response?.data
            if (data?.errors) setErrors(data.errors)
            else setError(extractErrors(err, 'Unable to sign in.'))
        } finally {
            setLoading(false)
        }
    }

    return (
        <div className="space-y-6">
            <div className="text-center">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Welcome Back</h1>
                <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Sign in to your PulseTrade account</p>
            </div>

            {error && (
                <div className="flex items-start gap-2 rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                    <AlertCircle size={16} className="mt-0.5 shrink-0" />
                    <span>{error}</span>
                </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label htmlFor="email" className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Email
                    </label>
                    <div className="relative">
                        <Mail size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input
                            id="email"
                            type="email"
                            autoComplete="email"
                            required
                            className="input pl-10"
                            placeholder="you@example.com"
                            value={form.email}
                            onChange={(e) => setForm({ ...form, email: e.target.value })}
                        />
                    </div>
                    {errors.email && <p className="mt-1 text-xs text-rose-500">{errors.email[0]}</p>}
                </div>

                <div>
                    <label htmlFor="password" className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Password
                    </label>
                    <div className="relative">
                        <Lock size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input
                            id="password"
                            type={showPassword ? 'text' : 'password'}
                            autoComplete="current-password"
                            required
                            className="input pl-10 pr-10"
                            placeholder="••••••••"
                            value={form.password}
                            onChange={(e) => setForm({ ...form, password: e.target.value })}
                        />
                        <button
                            type="button"
                            onClick={() => setShowPassword((v) => !v)}
                            className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                            aria-label={showPassword ? 'Hide password' : 'Show password'}
                        >
                            {showPassword ? <EyeOff size={16} /> : <Eye size={16} />}
                        </button>
                    </div>
                    {errors.password && <p className="mt-1 text-xs text-rose-500">{errors.password[0]}</p>}
                </div>

                <div className="flex items-center justify-between">
                    <label className="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <input
                            type="checkbox"
                            checked={form.remember}
                            onChange={(e) => setForm({ ...form, remember: e.target.checked })}
                            className="h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500"
                        />
                        Remember me
                    </label>
                </div>

                <button type="submit" disabled={loading} className="btn btn-primary w-full">
                    <LogIn size={18} />
                    {loading ? 'Signing in...' : 'Sign In'}
                </button>
            </form>

            <div className="rounded-lg bg-slate-50 p-3 text-center text-xs text-slate-500 dark:bg-brand-800/50 dark:text-slate-400">
                Demo credentials — <strong>Admin:</strong> admin@pulsetrade.com / password ·{' '}
                <strong>Customer:</strong> user@pulsetrade.com / password
            </div>

            <p className="text-center text-sm text-slate-500 dark:text-slate-400">
                Don't have an account?{' '}
                <Link to="/register" className="font-semibold text-brand-700 hover:text-brand-500 dark:text-sky-400">
                    Create one
                </Link>
            </p>
        </div>
    )
}
