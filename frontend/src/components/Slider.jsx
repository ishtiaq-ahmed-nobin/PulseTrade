import { Swiper, SwiperSlide } from 'swiper/react'
import { Navigation, Autoplay } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/autoplay'
import ProductCard from './ProductCard'
import { ChevronLeft, ChevronRight } from 'lucide-react'

export default function ProductSlider({ products, id = 'slider' }) {
    if (!products || products.length === 0) return null

    const nextId = `${id}-next`
    const prevId = `${id}-prev`

    return (
        <div className="relative">
            <div className="absolute -top-12 right-0 z-10 hidden gap-2 sm:flex">
                <button
                    type="button"
                    aria-label="Previous products"
                    className="rounded-full border border-slate-300 bg-white p-2 text-slate-600 shadow-sm transition-colors hover:border-brand-500 hover:text-brand-600 dark:border-brand-700 dark:bg-brand-900 dark:text-slate-300"
                >
                    <ChevronLeft size={18} />
                </button>
                <button
                    type="button"
                    aria-label="Next products"
                    className="rounded-full border border-slate-300 bg-white p-2 text-slate-600 shadow-sm transition-colors hover:border-brand-500 hover:text-brand-600 dark:border-brand-700 dark:bg-brand-900 dark:text-slate-300"
                >
                    <ChevronRight size={18} />
                </button>
            </div>

            <Swiper
                modules={[Navigation, Autoplay]}
                spaceBetween={20}
                slidesPerView={1}
                navigation={{
                    nextEl: `#${nextId}`,
                    prevEl: `#${prevId}`,
                }}
                autoplay={{ delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true }}
                breakpoints={{
                    480: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                    1024: { slidesPerView: 4 },
                    1280: { slidesPerView: 5 },
                }}
                className="!overflow-visible sm:!overflow-hidden"
            >
                {products.map((product) => (
                    <SwiperSlide key={product.id} className="h-auto py-1">
                        <ProductCard product={product} />
                    </SwiperSlide>
                ))}
            </Swiper>

            <button id={prevId} className="hidden" aria-hidden="true" tabIndex={-1} />
            <button id={nextId} className="hidden" aria-hidden="true" tabIndex={-1} />
        </div>
    )
}
