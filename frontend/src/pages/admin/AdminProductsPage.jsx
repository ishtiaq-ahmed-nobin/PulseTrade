import { useCallback, useEffect, useState } from 'react'
import {
    Plus,
    Search,
    Pencil,
    Trash2,
    X,
    ImagePlus,
    Loader2,
    ChevronLeft,
    ChevronRight,
    Package,
} from 'lucide-react'
import api, { extractErrors } from '../../services/api'
import { getImageUrl, resolveImageUrl } from '../../utils/image'
import { formatPrice, getCurrencySymbol, STOCK_STYLES, stockLabel } from '../../utils/format'
import Loader from '../../components/Loader'

const EMPTY_FORM = {
    category_id: '',
    name: '',
    description: '',
    price: '',
    sale_price: '',
    stock: '10',
    is_featured: false,
    image_url: '',
    gallery_urls: [''],
    remove_images: [],
}

export default function AdminProductsPage() {
    const [data, setData] = useState(null)
    const [categories, setCategories] = useState([])
    const [loading, setLoading] = useState(true)
    const [q, setQ] = useState('')
    const [category, setCategory] = useState('')
    const [stockFilter, setStockFilter] = useState('')
    const [page, setPage] = useState(1)
    const [modalOpen, setModalOpen] = useState(false)
    const [editing, setEditing] = useState(null)
    const [form, setForm] = useState({ ...EMPTY_FORM, gallery_urls: [''] })
    const [imageFile, setImageFile] = useState(null)
    const [imagePreview, setImagePreview] = useState('')
    const [galleryFiles, setGalleryFiles] = useState([])
    const [saving, setSaving] = useState(false)
    const [formError, setFormError] = useState('')
    const [toast, setToast] = useState('')

    const fetchProducts = useCallback(() => {
        setLoading(true)
        const params = { page }
        if (q) params.q = q
        if (category) params.category = category
        if (stockFilter) params.stock = stockFilter

        api.get('/admin/products', { params })
            .then(({ data }) => setData(data))
            .catch(() => {})
            .finally(() => setLoading(false))
    }, [q, category, stockFilter, page])

    useEffect(() => {
        fetchProducts()
    }, [fetchProducts])

    useEffect(() => {
        api.get('/admin/categories')
            .then(({ data }) => setCategories(data.parents))
            .catch(() => {})
    }, [])

    function openCreate() {
        setEditing(null)
        setForm({ ...EMPTY_FORM, gallery_urls: [''] })
        setImageFile(null)
        setImagePreview('')
        setGalleryFiles([])
        setFormError('')
        setModalOpen(true)
    }

    function openEdit(product) {
        setEditing(product)
        setForm({
            category_id: product.category_id,
            name: product.name,
            description: product.description || '',
            price: product.price,
            sale_price: product.sale_price || '',
            stock: product.stock,
            is_featured: Boolean(product.is_featured),
            image_url: '',
            gallery_urls: [''],
            remove_images: [],
        })
        setImageFile(null)
        setImagePreview(getImageUrl(product))
        setGalleryFiles([])
        setFormError('')
        setModalOpen(true)
    }

    function updateForm(field, value) {
        setForm((f) => ({ ...f, [field]: value }))
    }

    function handleImageChange(e) {
        const file = e.target.files?.[0]
        if (!file) return
        setImageFile(file)
        setImagePreview(URL.createObjectURL(file))
    }

    function handleGalleryChange(e) {
        const files = Array.from(e.target.files || [])
        setGalleryFiles((prev) => [...prev, ...files])
    }

    function removeGalleryFile(index) {
        setGalleryFiles((prev) => prev.filter((_, i) => i !== index))
    }

    function removeExistingImage(path) {
        setForm((f) => ({
            ...f,
            remove_images: [...f.remove_images, path],
            gallery_urls: f.gallery_urls.filter((u) => u !== path),
        }))
    }

    async function handleSubmit(e) {
        e.preventDefault()
        setSaving(true)
        setFormError('')

        const fd = new FormData()
        Object.entries(form).forEach(([key, value]) => {
            if (key === 'gallery_urls') {
                value.forEach((url) => {
                    if (url.trim()) fd.append('gallery_urls[]', url.trim())
                })
                return
            }
            if (key === 'remove_images') {
                value.forEach((path) => fd.append('remove_images[]', path))
                return
            }
            if (key === 'is_featured') {
                fd.append('is_featured', value ? '1' : '0')
                return
            }
            fd.append(key, value)
        })
        if (imageFile) fd.append('image', imageFile)
        galleryFiles.forEach((file) => fd.append('images[]', file))

        try {
            if (editing) {
                const { data: res } = await api.put(`/admin/products/${editing.id}`, fd, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                })
                setToast(res.message)
            } else {
                const { data: res } = await api.post('/admin/products', fd, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                })
                setToast(res.message)
            }
            setModalOpen(false)
            fetchProducts()
        } catch (err) {
            setFormError(extractErrors(err, 'Unable to save product.'))
        } finally {
            setSaving(false)
        }
    }

    async function handleDelete(product) {
        if (!window.confirm(`Delete "${product.name}"? This cannot be undone.`)) return
        try {
            const { data: res } = await api.delete(`/admin/products/${product.id}`)
            setToast(res.message)
            fetchProducts()
        } catch {
            setToast('Unable to delete product.')
        }
    }

    useEffect(() => {
        if (!toast) return
        const t = setTimeout(() => setToast(''), 3000)
        return () => clearTimeout(t)
    }, [toast])

    const editingGallery = editing
        ? (editing.images || []).filter((img) => !form.remove_images.includes(img))
        : []

    return (
        <div className="space-y-6">
            <div className="flex flex-wrap items-center justify-between gap-4">
                <h1 className="text-2xl font-bold text-brand-900 dark:text-white">Products</h1>
                <button type="button" onClick={openCreate} className="btn btn-primary">
                    <Plus size={18} /> Add Product
                </button>
            </div>

            <div className="card flex flex-wrap items-center gap-3 p-4">
                <div className="relative min-w-[200px] flex-1">
                    <Search size={16} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        className="input !py-2 pl-9"
                        placeholder="Search products..."
                        value={q}
                        onChange={(e) => {
                            setQ(e.target.value)
                            setPage(1)
                        }}
                    />
                </div>
                <select className="input !w-auto !py-2" value={category} onChange={(e) => { setCategory(e.target.value); setPage(1) }}>
                    <option value="">All Categories</option>
                    {categories.map((c) => (
                        <option key={c.id} value={c.id}>{c.name}</option>
                    ))}
                </select>
                <select className="input !w-auto !py-2" value={stockFilter} onChange={(e) => { setStockFilter(e.target.value); setPage(1) }}>
                    <option value="">All Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                </select>
            </div>

            {toast && (
                <div className="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                    {toast}
                </div>
            )}

            {loading ? (
                <Loader />
            ) : data?.data?.length === 0 ? (
                <div className="card flex flex-col items-center gap-3 p-14 text-center">
                    <Package size={48} className="text-slate-300 dark:text-brand-700" />
                    <p className="font-semibold text-brand-900 dark:text-white">No products found</p>
                    <button type="button" onClick={openCreate} className="btn btn-primary mt-2">Add your first product</button>
                </div>
            ) : (
                <div className="card overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-brand-800 dark:text-slate-400">
                                <tr>
                                    <th className="px-5 py-3">Product</th>
                                    <th className="px-5 py-3">Category</th>
                                    <th className="px-5 py-3">Price</th>
                                    <th className="px-5 py-3">Stock</th>
                                    <th className="px-5 py-3">Featured</th>
                                    <th className="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 dark:divide-brand-800">
                                {data.data.map((product) => (
                                    <tr key={product.id} className="hover:bg-slate-50 dark:hover:bg-brand-800/50">
                                        <td className="px-5 py-3">
                                            <div className="flex items-center gap-3">
                                                <img src={getImageUrl(product)} alt={product.name} className="h-10 w-10 rounded-lg object-cover" />
                                                <div>
                                                    <p className="font-semibold text-brand-900 dark:text-white">{product.name}</p>
                                                    <p className="text-xs text-slate-400">#{product.id}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-5 py-3 text-slate-500">{product.category?.name}</td>
                                        <td className="px-5 py-3">
                                            <span className="font-semibold text-brand-900 dark:text-white">{formatPrice(product.final_price)}</span>
                                            {product.has_discount && (
                                                <span className="ml-1 text-xs text-slate-400 line-through">{formatPrice(product.price)}</span>
                                            )}
                                        </td>
                                        <td className="px-5 py-3">
                                            <span className={`badge ${STOCK_STYLES[product.stock_status]}`}>{stockLabel(product.stock_status)}</span>
                                            <span className="ml-1 text-xs text-slate-500">({product.stock})</span>
                                        </td>
                                        <td className="px-5 py-3">
                                            {product.is_featured ? (
                                                <span className="badge bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300">Featured</span>
                                            ) : (
                                                <span className="text-slate-300">—</span>
                                            )}
                                        </td>
                                        <td className="px-5 py-3">
                                            <div className="flex justify-end gap-1">
                                                <button
                                                    type="button"
                                                    onClick={() => openEdit(product)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-brand-50 hover:text-brand-700 dark:hover:bg-brand-800"
                                                    aria-label={`Edit ${product.name}`}
                                                >
                                                    <Pencil size={16} />
                                                </button>
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(product)}
                                                    className="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-900/20"
                                                    aria-label={`Delete ${product.name}`}
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
                    {data && data.last_page > 1 && (
                        <div className="flex items-center justify-between border-t border-slate-200 px-5 py-3 dark:border-brand-800">
                            <p className="text-sm text-slate-500">
                                Page {data.current_page} of {data.last_page}
                            </p>
                            <div className="flex gap-2">
                                <button
                                    type="button"
                                    disabled={data.current_page <= 1}
                                    onClick={() => setPage((p) => p - 1)}
                                    className="btn btn-outline !p-2"
                                    aria-label="Previous page"
                                >
                                    <ChevronLeft size={16} />
                                </button>
                                <button
                                    type="button"
                                    disabled={data.current_page >= data.last_page}
                                    onClick={() => setPage((p) => p + 1)}
                                    className="btn btn-outline !p-2"
                                    aria-label="Next page"
                                >
                                    <ChevronRight size={16} />
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            )}

            {/* Modal */}
            {modalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={() => setModalOpen(false)} />
                    <div className="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl dark:bg-brand-900">
                        <div className="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4 dark:border-brand-800 dark:bg-brand-900">
                            <h2 className="text-lg font-bold text-brand-900 dark:text-white">
                                {editing ? 'Edit Product' : 'Add Product'}
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

                            <div className="grid gap-4 sm:grid-cols-2">
                                <div className="sm:col-span-2">
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Product Name</label>
                                    <input className="input" required value={form.name} onChange={(e) => updateForm('name', e.target.value)} />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                                    <select className="input" required value={form.category_id} onChange={(e) => updateForm('category_id', e.target.value)}>
                                        <option value="">Select category</option>
                                        {categories.map((c) => (
                                            <option key={c.id} value={c.id}>{c.name}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="flex items-end">
                                    <label className="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                                        <input
                                            type="checkbox"
                                            checked={form.is_featured}
                                            onChange={(e) => updateForm('is_featured', e.target.checked)}
                                            className="h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500"
                                        />
                                        Featured product
                                    </label>
                                </div>
                                <div className="sm:col-span-2">
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
                                    <textarea rows={3} className="input" required value={form.description} onChange={(e) => updateForm('description', e.target.value)} />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Price ({getCurrencySymbol()})</label>
                                    <input type="number" min="0" step="0.01" className="input" required value={form.price} onChange={(e) => updateForm('price', e.target.value)} />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Sale Price ({getCurrencySymbol()})</label>
                                    <input type="number" min="0" step="0.01" className="input" value={form.sale_price} onChange={(e) => updateForm('sale_price', e.target.value)} />
                                </div>
                                <div>
                                    <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Stock</label>
                                    <input type="number" min="0" step="1" className="input" required value={form.stock} onChange={(e) => updateForm('stock', e.target.value)} />
                                </div>
                            </div>

                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Main Image</label>
                                <div className="flex items-start gap-4">
                                    {imagePreview && (
                                        <img src={imagePreview} alt="Preview" className="h-20 w-20 rounded-lg border border-slate-200 object-cover dark:border-brand-800" />
                                    )}
                                    <div className="flex-1 space-y-2">
                                        <label className="flex cursor-pointer items-center gap-2 rounded-lg border border-dashed border-slate-300 p-3 text-sm text-slate-500 hover:border-brand-500 hover:text-brand-700 dark:border-brand-700 dark:text-slate-400">
                                            <ImagePlus size={18} />
                                            Upload image
                                            <input type="file" accept="image/*" className="hidden" onChange={handleImageChange} />
                                        </label>
                                        <input
                                            className="input !py-2"
                                            placeholder="...or paste an image URL"
                                            value={form.image_url}
                                            onChange={(e) => {
                                                updateForm('image_url', e.target.value)
                                                if (e.target.value) setImagePreview(e.target.value)
                                            }}
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label className="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Gallery</label>
                                {editingGallery.length > 0 && (
                                    <div className="mb-3 flex flex-wrap gap-2">
                                        {editingGallery.map((img) => (
                                            <div key={img} className="relative">
                                                <img src={resolveImageUrl(img)} alt="" className="h-16 w-16 rounded-lg object-cover" />
                                                <button
                                                    type="button"
                                                    onClick={() => removeExistingImage(img)}
                                                    className="absolute -right-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-white"
                                                    aria-label="Remove image"
                                                >
                                                    <X size={12} />
                                                </button>
                                            </div>
                                        ))}
                                    </div>
                                )}
                                {galleryFiles.length > 0 && (
                                    <div className="mb-3 flex flex-wrap gap-2">
                                        {galleryFiles.map((file, i) => (
                                            <div key={i} className="relative">
                                                <img src={URL.createObjectURL(file)} alt="" className="h-16 w-16 rounded-lg object-cover" />
                                                <button
                                                    type="button"
                                                    onClick={() => removeGalleryFile(i)}
                                                    className="absolute -right-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-white"
                                                    aria-label="Remove image"
                                                >
                                                    <X size={12} />
                                                </button>
                                            </div>
                                        ))}
                                    </div>
                                )}
                                <label className="flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-dashed border-slate-300 p-3 text-sm text-slate-500 hover:border-brand-500 hover:text-brand-700 dark:border-brand-700 dark:text-slate-400">
                                    <ImagePlus size={18} />
                                    Add gallery images
                                    <input type="file" accept="image/*" multiple className="hidden" onChange={handleGalleryChange} />
                                </label>
                            </div>

                            <div className="flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-brand-800">
                                <button type="button" onClick={() => setModalOpen(false)} className="btn btn-outline">
                                    Cancel
                                </button>
                                <button type="submit" disabled={saving} className="btn btn-primary">
                                    {saving && <Loader2 size={16} className="animate-spin" />}
                                    {editing ? 'Save Changes' : 'Create Product'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    )
}
