const slides = [
  {
    title: 'New tech arrivals',
    subtitle: 'Discover smartphones, laptops and accessories for your daily workflow.',
    cta: 'Shop now',
  },
  {
    title: 'Build your perfect setup',
    subtitle: 'Choose products, variants and options powered by Symfony API Platform.',
    cta: 'Explore catalog',
  },
];

export function HeroSlider() {
  const slide = slides[0];

  return (
    <section className="mx-auto max-w-7xl px-6 py-10">
      <div className="overflow-hidden rounded-[2rem] border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-800">
        <div className="grid gap-8 p-8 md:grid-cols-2 md:p-14">
          <div className="flex flex-col justify-center">
            <span className="mb-4 w-fit rounded-full bg-white/10 px-4 py-2 text-sm text-slate-300">
              Featured collection
            </span>

            <h1 className="max-w-xl text-4xl font-bold tracking-tight md:text-6xl">
              {slide.title}
            </h1>

            <p className="mt-5 max-w-lg text-lg text-slate-300">
              {slide.subtitle}
            </p>

            <div className="mt-8 flex gap-3">
              <button className="rounded-full bg-white px-6 py-3 font-semibold text-slate-950">
                {slide.cta}
              </button>
              <button className="rounded-full border border-slate-600 px-6 py-3 font-semibold">
                View deals
              </button>
            </div>
          </div>

          <div className="flex min-h-[320px] items-center justify-center rounded-[1.5rem] bg-slate-950/60">
            <div className="text-center">
              <div className="mx-auto h-44 w-44 rounded-3xl bg-slate-700 shadow-2xl" />
              <p className="mt-6 text-sm text-slate-400">Product showcase placeholder</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}