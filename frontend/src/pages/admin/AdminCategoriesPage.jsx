import { useEffect, useState } from 'react'
import { Plus, Pencil, Trash2, X, Loader2, Tags } from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import Loader from '../../components/Loader'

const EMPTY_FORM = { name: '', description: '', parent_id: '' }

export default function AdminCategoriesPage() {
    const [categories, setCategories] = useState([])
    const [parents, setParents] = useState([])
    const [loading, setLoading] = useState(true)
    const [modalOpen, setModalOpen] = useState(false)
    const [editing, setEditing] = useState(null)
    const [form, setForm] = useState({ ...EMPTY_FORM })
    const [saving, setSaving] = useState(false)
    const [formError, setFormError] = useState('')
    const [toast, setToast] = useState('')

    function fetchCategories() {
        setLoading(true)
        api.get('/admin/categories')
            .then(({ data }) => {
                setCategories(data.categories)
                setParents(data.parents)
            })
            .catch(() => {})
            .finally(() => setLoading(false))
    }

    useEffect(() => {
        fetchCategories()
    }, [])

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    function openCreate() {
        setEditing(null)
        setForm({ ...EMPTY_FORM })
        setFormError('')
        setModalOpen(true)
    }

    function openEdit(category) {
        setEditing(category)
        setForm({
            name: category.name,
            description: category.description || '',
            parent_id: category.parent_id || '',
        })
        setFormError('')
        setModalOpen(true)
    }

    async function handleSubmit(e) {
        e.preventDefault()
        setSaving(true)
        setFormError('')
        try {
            if (editing) {
                const { data: res } = await api.put(`/admin/categories/${editing.id}`, form)
                setToast(res.message)
            } else {
                const { data: res } = await api.post('/admin/categories', form)
                setToast(res.message)
            }
            setModalOpen(false)
            fetchCategories()
        } catch (err) {
            setFormError(extractErrors(err, 'Unable to save category.'))
        } finally {
            setSaving(false)
        }
    }

    async function handleDelete(category) {
        const count = category.products_count
        const warning =
            count > 0
                ? `Delete "${category.name}"? This will also delete ${count} product(s) and unlink its children.`
                : `Delete "${category.name}"?`
        if (!window.confirm(warning)) return
        try {
            const { data: res } = await api.delete(`/admin/categories/${category.id}`)
            setToast(res.message)
            fetchCategories()
        } catch {
            setToast('Unable to delete category.')
        }
    }

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Categories</h1>
                <button type="button" onClick={openCreate} className="btn btn-primary">
                    <Plus size={18} /> Add Category
                </button>
            </div>

            {toast && (
                <div className="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                    {toast}
                </div>
            )}

            {loading ? (
                <Loader />
            ) : categories.length === 0 ? (
                <div className="card flex flex-col items-center gap-3 p-14 text-center">
                    <Tags size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No categories yet</p>
                    <button type="button" onClick={openCreate} className="btn btn-primary mt-2">Add your first category</button>
                </div>
            ) : (
                <div className="card overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                                <tr>
                                    <th className="px-5 py-3">Name</th>
                                    <th className="px-5 py-3">Parent</th>
                                    <th className="px-5 py-3">Products</th>
                                    <th className="px-5 py-3">Children</th>
                                    <th className="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                                {categories.map((category) => (
                                    <tr key={category.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                        <td className="px-5 py-3">
                                            <p className="font-semibold text-brand-900 dark:text-white">{category.name}</p>
                                            {category.description && (
                                                <p className="max-w-md truncate text-xs text-slate-400">{category.description}</p>
                                            )}
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{category.parent?.name || '—'}</td>
                                        <td className="px-5 py-3">
                                            <span className="badge bg-brand-100 text-brand-700 dark:bg-brand-800 dark:text-brand-200">
                                                {category.products_count}
                                            </span>
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{category.children?.length || 0}</td>
                                        <td className="px-5 py-3">
                                            <div className="flex justify-end gap-1">
                                                <button
                                                    type="button"
                                                    onClick={() => openEdit(category)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-brand-50 hover:text-brand-700 dark:hover:bg-brand-800"
                                                    aria-label={`Edit ${category.name}`}
                                                >
                                                    <Pencil size={16} />
                                                </button>
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(category)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                                    aria-label={`Delete ${category.name}`}
                                                >
                                                    <Trash2 size={16} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            )}

            {modalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={() => setModalOpen(false)} />
                    <div className="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-brand-900">
                        <div className="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-brand-800">
                            <h2 className="text-lg font-bold text-brand-900 dark:text-white">
                                {editing ? 'Edit Category' : 'Add Category'}
                            </h2>
                            <button
                                type="button"
                                onClick={() => setModalOpen(false)}
                                className="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-brand-800"
                                aria-label="Close"
                            >
                                <X size={20} />
                            </button>
                        </div>
                        <form onSubmit={handleSubmit} className="space-y-4 p-6">
                            {formError && (
                                <div className="rounded-lg bg-rose-50 p-3 text-sm text-rose-700 dark:bg-rose-900/20 dark:text-rose-300">
                                    {formError}
                                </div>
                            )}
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                                <input className="input" required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} />
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Parent Category</label>
                                <select
                                    className="input"
                                    value={form.parent_id}
                                    onChange={(e) => setForm({ ...form, parent_id: e.target.value })}
                                >
                                    <option value="">None (top-level)</option>
                                    {parents
                                        .filter((p) => p.id !== editing?.id)
                                        .map((p) => (
                                            <option key={p.id} value={p.id}>{p.name}</option>
                                        ))}
                                </select>
                            </div>
                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
                                <textarea rows={3} className="input" value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })} />
                            </div>
                            <div className="flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-brand-800">
                                <button type="button" onClick={() => setModalOpen(false)} className="btn btn-outline">Cancel</button>
                                <button type="submit" disabled={saving} className="btn btn-primary">
                                    {saving && <Loader2 size={16} className="animate-spin" />}
                                    {editing ? 'Save Changes' : 'Create Category'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    )
}
