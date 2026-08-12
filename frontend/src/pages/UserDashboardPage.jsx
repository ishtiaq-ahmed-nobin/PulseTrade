import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import { User, Package, KeyRound, Loader2, CheckCircle2, AlertCircle, ChevronRight } from 'lucide-react'
import api, { extractErrors } from '../services/api'
import { useAuth } from '../context/AuthContext'
import { formatPrice, formatDateTime, STATUS_LABELS, STATUS_STYLES, PAYMENT_LABELS } from '../utils/format'
import Loader from '../components/Loader'
import { getImageUrl } from '../utils/image'

export default function UserDashboardPage() {
    const { user, updateProfile, changePassword } = useAuth()
    const [orders, setOrders] = useState([])
    const [loadingOrders, setLoadingOrders] = useState(true)
    const [profileForm, setProfileForm] = useState({ name: '', phone: '', address: '' })
    const [passwordForm, setPasswordForm] = useState({ current_password: '', password: '', password_confirmation: '' })
    const [profileMsg, setProfileMsg] = useState('')
    const [profileErr, setProfileErr] = useState('')
    const [pwdMsg, setPwdMsg] = useState('')
    const [pwdErr, setPwdErr] = useState('')
    const [savingProfile, setSavingProfile] = useState(false)
    const [savingPwd, setSavingPwd] = useState(false)
    const [activeTab, setActiveTab] = useState('orders')

    useEffect(() => {
        if (user) {
            setProfileForm({ name: user.name, phone: user.phone || '', address: user.address || '' })
        }
        api.get('/orders')
            .then(({ data }) => setOrders(data.data))
            .catch(() => setOrders([]))
            .finally(() => setLoadingOrders(false))
    }, [user])

    async function handleProfile(e) {
        e.preventDefault()
        setSavingProfile(true)
        setProfileMsg('')
        setProfileErr('')
        try {
            await updateProfile(profileForm)
            setProfileMsg('Profile updated successfully.')
        } catch (err) {
            setProfileErr(extractErrors(err, 'Unable to update profile.'))
        } finally {
            setSavingProfile(false)
        }
    }

    async function handlePassword(e) {
        e.preventDefault()
        setSavingPwd(true)
        setPwdMsg('')
        setPwdErr('')
        try {
            await changePassword(passwordForm)
            setPasswordForm({ current_password: '', password: '', password_confirmation: '' })
            setPwdMsg('Password changed successfully.')
        } catch (err) {
            setPwdErr(extractErrors(err, 'Unable to change password.'))
        } finally {
            setSavingPwd(false)
        }
    }

    const TABS = [
        { id: 'orders', label: 'My Orders', icon: Package },
        { id: 'profile', label: 'Profile', icon: User },
        { id: 'password', label: 'Password', icon: KeyRound },
    ]

    return (
        <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <div className="mb-8 flex items-center gap-4">
                <span className="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-900 text-xl font-bold text-white dark:bg-brand-500">
                    {user?.name?.charAt(0)?.toUpperCase()}
                </span>
                <div>
                    <h1 className="text-2xl font-extrabold text-brand-900 dark:text-white">{user?.name}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">{user?.email}</p>
                </div>
            </div>

            <div className="mb-6 flex gap-1 border-b border-slate-200 dark:border-brand-800">
                {TABS.map(({ id, label, icon: Icon }) => (
                    <button
                        key={id}
                        type="button"
                        onClick={() => setActiveTab(id)}
                        className={`flex items-center gap-2 border-b-2 px-4 py-3 text-sm font-semibold transition-colors ${
                            activeTab === id
                                ? 'border-brand-700 text-brand-700 dark:border-sky-400 dark:text-sky-400'
                                : 'border-transparent text-slate-500 hover:text-brand-700 dark:text-slate-400'
                        }`}
                    >
                        <Icon size={16} /> {label}
                    </button>
                ))}
            </div>

            {activeTab === 'orders' && (
                loadingOrders ? (
                    <Loader />
                ) : orders.length === 0 ? (
                    <div className="card flex flex-col items-center gap-3 p-14 text-center">
                        <Package size={48} className="text-slate-300 dark:text-brand-700" />
                        <p className="font-semibold text-brand-900 dark:text-white">No orders yet</p>
                        <Link to="/shop" className="btn btn-primary mt-2">Start Shopping</Link>
                    </div>
                ) : (
                    <div className="space-y-4">
                        {orders.map((order) => (
                            <div key={order.id} className="card p-5">
                                <div className="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <p className="font-bold text-brand-900 dark:text-white">{order.order_number}</p>
                                        <p className="text-xs text-slate-500 dark:text-slate-400">
                                            {formatDateTime(order.created_at)} · {order.items.length} items
                                        </p>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <span className={`badge ${STATUS_STYLES[order.status]}`}>{STATUS_LABELS[order.status]}</span>
                                        <span className="badge bg-slate-100 text-slate-700 dark:bg-brand-800 dark:text-slate-300">
                                            {PAYMENT_LABELS[order.payment_status]}
                                        </span>
                                        <span className="font-bold text-brand-900 dark:text-white">{formatPrice(order.total_amount)}</span>
                                    </div>
                                </div>
                                <div className="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                                    {order.items.map((item) => (
                                        <div key={item.id} className="flex items-center gap-2">
                                            <img
                                                src={getImageUrl(item.product)}
                                                alt={item.product.name}
                                                className="h-12 w-12 rounded-lg object-cover"
                                            />
                                            <div className="min-w-0">
                                                <p className="truncate text-xs font-semibold text-brand-900 dark:text-white">{item.product.name}</p>
                                                <p className="text-xs text-slate-500">× {item.quantity}</p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ))}
                    </div>
                )
            )}

            {activeTab === 'profile' && (
                <form onSubmit={handleProfile} className="card max-w-xl space-y-4 p-6">
                    {profileMsg && (
                        <div className="flex items-center gap-2 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                            <CheckCircle2 size={16} /> {profileMsg}
                        </div>
                    )}
                    {profileErr && (
                        <div className="flex items-center gap-2 rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                            <AlertCircle size={16} /> {profileErr}
                        </div>
                    )}
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                        <input className="input" value={profileForm.name} onChange={(e) => setProfileForm({ ...profileForm, name: e.target.value })} required />
                    </div>
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input className="input" value={user?.email} disabled />
                    </div>
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
                        <input className="input" value={profileForm.phone} onChange={(e) => setProfileForm({ ...profileForm, phone: e.target.value })} />
                    </div>
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Address</label>
                        <textarea rows={3} className="input" value={profileForm.address} onChange={(e) => setProfileForm({ ...profileForm, address: e.target.value })} />
                    </div>
                    <button type="submit" disabled={savingProfile} className="btn btn-primary">
                        {savingProfile && <Loader2 size={16} className="animate-spin" />}
                        Save Changes
                    </button>
                </form>
            )}

            {activeTab === 'password' && (
                <form onSubmit={handlePassword} className="card max-w-xl space-y-4 p-6">
                    {pwdMsg && (
                        <div className="flex items-center gap-2 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                            <CheckCircle2 size={16} /> {pwdMsg}
                        </div>
                    )}
                    {pwdErr && (
                        <div className="flex items-center gap-2 rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                            <AlertCircle size={16} /> {pwdErr}
                        </div>
                    )}
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Current Password</label>
                        <input type="password" className="input" value={passwordForm.current_password} onChange={(e) => setPasswordForm({ ...passwordForm, current_password: e.target.value })} required />
                    </div>
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">New Password</label>
                        <input type="password" className="input" value={passwordForm.password} onChange={(e) => setPasswordForm({ ...passwordForm, password: e.target.value })} required />
                    </div>
                    <div>
                        <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm New Password</label>
                        <input type="password" className="input" value={passwordForm.password_confirmation} onChange={(e) => setPasswordForm({ ...passwordForm, password_confirmation: e.target.value })} required />
                    </div>
                    <button type="submit" disabled={savingPwd} className="btn btn-primary">
                        {savingPwd && <Loader2 size={16} className="animate-spin" />}
                        Update Password
                    </button>
                </form>
            )}
        </div>
    )
}
