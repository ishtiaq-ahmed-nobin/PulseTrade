import { useState } from 'react'
import { ChevronDown } from 'lucide-react'

const FAQS = [
    { q: 'How long does shipping take?', a: 'Standard shipping takes 3-5 business days. Orders over $100 ship free.' },
    { q: 'What is your return policy?', a: 'You have 30 days from delivery to return any item in its original condition for a full refund.' },
    { q: 'Do you offer product warranties?', a: 'Yes — all electronics include at least a 1-year manufacturer warranty, with up to 2 years on selected gear.' },
    { q: 'What payment methods do you accept?', a: 'We accept all major credit/debit cards and cash on delivery. Card payments are processed securely.' },
    { q: 'How do I track my order?', a: 'Once your order ships, you will receive a confirmation email with a tracking link.' },
    { q: 'Can I cancel my order?', a: 'Yes, as long as the order has not yet shipped. Contact support and we will cancel it for you.' },
]

export default function FaqPage() {
    const [open, setOpen] = useState(0)

    return (
        <div className="mx-auto max-w-3xl px-4 py-14 sm:px-6">
            <h1 className="mb-8 text-4xl font-extrabold text-brand-900 dark:text-white">Frequently Asked Questions</h1>
            <div className="space-y-3">
                {FAQS.map((faq, i) => (
                    <div key={i} className="card overflow-hidden">
                        <button
                            type="button"
                            onClick={() => setOpen(open === i ? -1 : i)}
                            className="flex w-full items-center justify-between gap-4 p-5 text-left"
                        >
                            <span className="font-semibold text-brand-900 dark:text-white">{faq.q}</span>
                            <ChevronDown
                                size={18}
                                className={`shrink-0 text-slate-400 transition-transform ${open === i ? 'rotate-180' : ''}`}
                            />
                        </button>
                        {open === i && <p className="border-t border-slate-100 p-5 text-sm text-slate-600 dark:border-brand-800 dark:text-slate-300">{faq.a}</p>}
                    </div>
                ))}
            </div>
        </div>
    )
}
