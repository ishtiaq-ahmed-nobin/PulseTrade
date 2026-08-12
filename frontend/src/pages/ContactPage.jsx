import { useState } from 'react'
import { Mail, Phone, MapPin, Send, CheckCircle2 } from 'lucide-react'

export default function ContactPage() {
    const [form, setForm] = useState({ name: '', email: '', subject: '', message: '' })
    const [sent, setSent] = useState(false)

    function handleSubmit(e) {
        e.preventDefault()
        setSent(true)
    }

    return (
        <div className="mx-auto max-w-7xl px-4 py-14 sm:px-6">
            <div className="mb-10 max-w-2xl">
                <h1 className="text-4xl font-extrabold text-brand-900 dark:text-white">Contact Us</h1>
                <p className="mt-3 text-slate-600 dark:text-slate-300">
                    Questions, feedback or need help with an order? Our team responds within 24 hours.
                </p>
            </div>

            <div className="grid gap-10 lg:grid-cols-[1fr_380px]">
                <div className="card p-6">
                    {sent ? (
                        <div className="flex flex-col items-center gap-3 py-10 text-center">
                            <CheckCircle2 size={48} className="text-emerald-500" />
                            <h2 className="text-xl font-bold text-brand-900 dark:text-white">Message Sent!</h2>
                            <p className="text-slate-500 dark:text-slate-400">Thanks for reaching out — we'll get back to you shortly.</p>
                        </div>
                    ) : (
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                                    <input className="input" required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                                    <input type="email" className="input" required value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} />
                                </div>
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
                                <input className="input" required value={form.subject} onChange={(e) => setForm({ ...form, subject: e.target.value })} />
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Message</label>
                                <textarea rows={5} className="input" required value={form.message} onChange={(e) => setForm({ ...form, message: e.target.value })} />
                            </div>
                            <button type="submit" className="btn btn-primary">
                                <Send size={16} /> Send Message
                            </button>
                        </form>
                    )}
                </div>

                <div className="space-y-4">
                    {[
                        { icon: Mail, title: 'Email', value: 'hello@pulsetrade.com' },
                        { icon: Phone, title: 'Phone', value: '+1 (800) 555-9876' },
                        { icon: MapPin, title: 'Store', value: '100 Tech Park Blvd, San Francisco, CA 94105' },
                    ].map(({ icon: Icon, title, value }) => (
                        <div key={title} className="card flex items-start gap-4 p-5">
                            <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700 dark:bg-brand-800 dark:text-sky-400">
                                <Icon size={20} />
                            </span>
                            <div>
                                <p className="font-semibold text-brand-900 dark:text-white">{title}</p>
                                <p className="text-sm text-slate-500 dark:text-slate-400">{value}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    )
}
