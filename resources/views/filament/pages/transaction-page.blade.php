<x-filament-panels::page>
    {{-- outer div --}}
    <div class="flex flex-col gap-3 xl:flex-row">
        {{-- first div --}}
        <div class="flex flex-col gap-3 xl:w-[850px]">
            {{-- scrollable --}}
            <div class="flex w-full p-1 overflow-x-auto gap-2">
                @foreach ($categories as $category)
                    <div class="flex gap-2 bg-red-500 px-3 py-0.5 rounded-full" x-data="{ category: {{ $category }} }">
                        {{-- <span class="bg-white text-red-500 font-semibold px-2 rounded-full">{{ $category->totals() }}</span> --}}
                        <span class="bg-white text-red-500 font-semibold px-2 rounded-full">{{ $category->totals() }}</span>
                        <p class="text-white font-semibold">{{ $category->name }}</p>
                    </div>
                @endforeach
            </div>
            {{-- item menu div --}}
            <div class="grid grid-cols-2 gap-3 mx-h-[580px] overflow-y-auto p-1">
                @foreach ($products as $product)
                    <div class="flex flex-col p-2 border rounded-md border-red-500 justify-evenly gap-2 transition duration-300 hover:-translate-y-1 select-none hover:cursor-pointer" x-on:click="$store.cart.add({{ $product }})">
                        <div class="flex flex-row">
                            <img class="border border-red-500 rounded-md mr-1.5 object-cover h-[4rem] w-[4rem]" src="{{ asset("storage/$product->image") }}" alt="">
                            <div class="flex flex-col justify-evenly">
                                <p class="text-xs">Stok: <span class="font-semibold">{{ $product->supply }} item</span></p>
                                <span class="p-0.5"></span>
                                <p class="text-xs">Kategori: <span class="font-semibold"><span>{{ $product->categories[0]->name ?? 'Tidak diketahui' }}</span></span></p>
                            </div>
                        </div>
                        <h3 class="text-xs font-bold">{{ $product->name }}</h4>
                        <p class="text-xs">Harga: <span class="font-semibold" x-text="rupiah({{ $product->price }})"></span></p>
                    </div>
                @endforeach
                {{-- <div class="flex flex-col p-2 border rounded-md border-red-500 justify-evenly gap-2">
                    <div class="flex flex-row">
                        <img class="border border-red-500 rounded-md mr-1.5 object-cover h-[4rem] w-[4rem]" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEBUQEBAVDw8VFRAQEA8QEBAPEBAPFRUWFhUVFRUYHSggGBolHRUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGBAQGysdHSUuLS0tKy8tLS0tLS0tLSstLS0vLS0tLS0tLS0tLy0tLS0rLS0tLy0tLS0rLS0rLS0vLf/AABEIAMMBAwMBIgACEQEDEQH/xAAcAAACAgMBAQAAAAAAAAAAAAABAgAHAwQGBQj/xABAEAABBAAEAggDBAgGAgMAAAABAAIDEQQSITFBUQUGEyJhcYGRMqGxBxRCwSMzUmJygtHwQ1NjssLxkuEVg6L/xAAbAQEBAAMBAQEAAAAAAAAAAAAAAQIDBAUGB//EADMRAAICAQIEAQsCBwAAAAAAAAABAhEDBCESMUFRBSIyYXGBkbHB0eHwQkMGExRSobLC/9oADAMBAAIRAxEAPwDncPjHPfbjdbb7jf1Vl/ZzHlwI/ekkd9G/8VVWCf3vR2g0vQq3uo0eXARDn2rtfGRy3z80wSVnQBOEgTBaTIyBFKEQoUdqZICmCoGCKW0VAFRRRARKUyVAK5IU5SqkEcEhCylIQgFATBBFUBUUQUBEpRQKACUolKVQApSmKQoAFIUxSlQCEJSmKUoUVRAlRQhSGC/E7wPpfD5q6uqjKwUA/wBNpPmbP5qmMKNCQL0Hnurv6EbWGhH+lF/sC2yfkkSrY3wnCQJwtZkMEyUJlAFEFBRUDhFKCioBlEApaAKFqIFUgCUqJQQAKUpkpQARQUVAUqKFoAIFElKVABAqEoFAAlKUSlKoFKUpikUACkKYpCoBVEEFQUlhDvwHM+avjBMyxsbyYwezQFQ+E1OXUnQDl4beav1bZ7JBDhOFjCcLUUyBMCsYKYIB0UoRBUAwRSqBUDhRLaNoQKBKFoICIIoIUBQKhKBQgFEEbVBClRQKACBUKCgAhahQKoAUpRQJUApSlEpShRSkcmKRyEFUQUUBTfQzLnibzkY2/NwH5q9LVIdWG5sXANx2sR8PiB/JXaFtn0K0ZAnCxhMCtYMgTArGCmCAyBEJAmCAZFLaKgCogpaAKiFqKgiBKhKUlCEKBUtAoAKIEqWgClUtBUEKBKloFAAoFQpSgISlJUKUqAhKUlQpSUAHLG5M4rG4oAWisdqIUqLqE7NjYLBvtOfIOP5K72qmvsvaPvYL3DNqI2sF33SXFxJ0FBXICsp9AZAmBSBEFYgyJgkBTBAPaZIiFAMjaUFG1QG1LQUUA1oEoWgqAkoEoEoEoCWgUCUpKEGtC0pchmVA1qErFJMB8RA8yAtObpiBvxTxj/7G39UBvoWvDxHWvCN/xs38DXO+dUtGTrxhhsJHfyNH1chaZ1BKUlchJ17i/DDIfMsb+ZWpL19P4YAP4pL+QASiqEjuCUpKr6Tr3N/lxD0ef+SwP68zn/KH8p/Nyhf5cixS5Y3SKspuumIP+K1u+0ce48wtGbrTOd8TJ/K7L/tCpVjbLXc9I4nkVT83WCQ/40rht+uf/Vac3TFnW3ce85x+pTYLGXTm/uwoqLPSLeTfZqiWhwMsP7OuhIQ9uIbPmkDX3B3XZb7tucNBvt4+isULGxoAoChwA0AThRuzFjhOsYKYIQe0wKQJkA4KYJAiCgHUtKioA2ilRBQBQKloICJSiUpQCuKRztFHFY3nulUHF9e+sU8EsccMnZgx53d1riSXEDUg1suPn60zu+LEv8RnLRW/Bb32lSXimD/SaP8A9vXK/oxqY2/+NpbN8Ixo2Jel2nd9nXUmz/7SHpJvN3hQJCWWcNbQAaToKAGvNGTEmgBodgpZt4UkR3SF7Ncf5HHT2SHGyHaF/wD4EWsk2LIpt0TtvypYsTi6Gpvet0sUhXTzb9i4XprlA+qRv3h1kR1rVlzVHYohoBN0PeuCVry1mnKzvrxQiSfUIw+IuiWi+cl6+g8Vjdh5DdyM57u1+Skc+a3bDYc1rST2ct67eicytRS2M7sE46mZmvABxrT+/ZQdHGxeIaNye4eHqscsla8BXzSskJ19ApZhSHkwrQP1zneUYH5pY8PGaJlk15Nbt6+a1Xy65b3+S2h/YVYVXYH4aG/ik9Q1RIYxzUQnCfSSIQKgVOcdMCkCYFCjgogpLRtQGQFG1jBRBQGS0bSAohCDgqWlRQBtAoWgSgCkcUS5ISgFcViee6UzysEr+67yKqBWnXfofEzTmWKB8sQbGwujAeQ8W4jKDm2cOFLkMRhHNoSsfFxGdro9tqvfj7KzcRjXQR4yYEgvMGHio7PyEuI5ENdd+C8XoLrVNhoxEA2SO7a199wcQ0g7ea58ueMJUz2NF4bl1GB5IVs6rv3OHprzZNlveaQRvexWQQgkOvVtkVx4Fd50j1tMgpuFgYf2nxNlPoHCh810nVXoWF0DZpsNC6Z9vzmCIOyuNt2bppSQzRm6iXU6LLpsfHlSVukrt/QqQYQPa6UAkRFoc9otjXO2DuROq13RNkNOJ07wrnwvwVw/aFCP/j5msAYAI390ADuyN5KlsOxzC5rqJsEEGxRFjX2W04IyT6G0cOJCGE15bqwek/s0BaPu0+tAOZPxNakPaNPKlXvRzXiQZvxFpabB0zL6BcaG9DifqqzGb32KaxvUTGQghkBkZvbHMeb8Bd/JeLL1emZcr4Jmm61hkDarnXNWRF16IOsPq12hb4g7e63I+vsOanRva3i7uGvS1pWeD6noS8L1i/bsqM9EyvH6qXITecRSEUPGqWF8IZ3Nq5iirmm694YfD2kg5tYB6d4hebjPtBH+FhrPOR/HyaNfdHqIdxj8L1cv237dviVII47JeacKoWKKd8g4Ee4X0JhJRJGwuDc5a0uGXQOI1q/FeX1o6bjwkLnGPtAMrZAGtoZjQbR01tbeI8+62KMdJ4n0r+qiOJDXPc5rCxpcXNY2y1jSbDQeQ2UWVGNs+lEFrdHjK0xjaNxYPBmjmD0a5o9FslU0jBG0lo2oUe1LS2ohaMgKIKxgogqCjKCmtYwUwKpBrQtS0CoQKFoWgShQpSUCUhdwQCyOWnK/uv8A4XfRbb4XHZv0C05MLJ3hlOrS0HcWfJVEOY6xOiazCRS6MkmdNLqQC1oDQXEagU4DTgCkg6LwExAjuyXmo5wzuh4a5w7TZozl2upEYrc35HXvEg4oRiwyJjI2hwy67uIvfcey5yx4Feblyrjdqz7bw/RT/pcbjNxdXty3t8tjLiQA5zWuzAOcGvr4gCQD67q6OimZYI28o4x7NAVIk6jXirqbiaiBA4DjVclnpFzZy/xG3WKPr+R4vXx4+44i/wDLc0DTUkKkTJVePHnsrE+0+eduFa1wDWPlDXZCSC2i4Ak67tCr2JwI9vTxHLZdqPm4dj1uhW58VBHqS6WJvpmF+lWruxcgMUhB/A//AGlU11Lw/a46AZc1P7TjoIwXX70rf6wOAw0z9iIpddr7pUnsjKK4skUu6Kogw8kmkbHSECyGMc8gDiQFJMDKBZifWVj77N1ZXmmEmtiRQ5r2ernT0eGY4PbJmzxytMLmsLyy6jkJ/Brei38J1yaBhxIHHLJK+fK0VRLuyy66hme6PILzFCDVtn3eTUamMmoY7S9PPZv7eto46ZjmnK9pY4btcC0jzBQwb/0rL1GYEjnWq9rrZ0pHMYRHI+d0bHNfiJGBj5CXWBXh+a8voOPPiom728X5cVIxXGktzZlzSlpZTkuF09vf8S2YXiKIO/FQH81LkOvvc6NkdJq6V0QaOPxh1n0BXXCLtCL+BvzK4/7UH3gyXGy6WIAbBrQb+gXpdT896lYMlIAFjQDgoi5w/vN/VRbye0+hsA6w942e8uaebWhrAR4HJY8CtpY2gAUBQGgA0ACyBQ0hUSqFQqCXIZ1jc9YnSKWbEjazpg5aJlTMmUsvCb7SmtebJ0pCzR80bDtTpGg/MrfhGcZmua5p2LXBwPqEsxlCSVtGS1C5M2DmfZZBG3l7qmBr2mEbjw99FsghS1AYBh+Z9k/3cf8ARIWS1EAgiHj7k/VBraFWT51+SyIEIDBNCHCnNa8cnCx81qzYGM74dj+HwR7eq36UUpGSk1yZ48nRGFJ7+DjB5mBhHuB4LO7CQHSm2eAdlJryK9EpHsB0IscjqESRZZJS5ts8DrF1XixcPYve+NtteCwiw5u2jgb3PuuQn+yoD9ViyPCSAH5tcFZJiHKvKx9FjdBye4fzX9VScTON6mdTH4Od8sr2SHJki7PMKzHv2CPAVrzXsdZoZHYWSONhe5wAaG6kjML+S9otfwcD/EK+YSyFwHwh3gDR+aklao2Y8rhNTW9NP3FLYnBzMNPiew8nRPb9RqtMnXgrzLzxYfQ39FjeWH4hpyeB+a5HpOzPoofxJJedj/z9ijiV6/VOvvbL5Orzr+lqzn9EYR5s4eJxO57JuvqAhF1fwjXBzYGNeLotJaddOBUhppRldl1Hj2LNhlDhabVdAvxLWNy7u/ZaC4gczWy4j7UwfukY+G5mOLTlsjK4X5aj3VjR4Njdh7kmvdcl146mnHdm4T9k+PPWaPOCHZdNHCvhXWlufNWilXy0dyNtKHJRdrJ9l+Kv9dCf5pR/xUW3jMOEuFM0pEzdUMQkoEE7C1mjaPNZwo2VHidJdpHGXiJ0ta5Y8pdXlevpZXIT9cDRyQ07bvusD0AF+6spc/1i6rRYkF7ain37QDR/g8cfPf6LRkU68k9HQ5tNGVZ42u++3rRwUvWjFOFZms8WMAPztediMbLJ8cjn/wATiR7LL0l0fJBJ2czMjuB3a4c2niNVqZVwylJ7Nn2WDDgSUsaXrQAFtYLGyRHNFI6I/uOLb8xxWsiFgm0dLipKmrR2/Q3XuRpDcS0SN27RgDZB5jZ3yXZ9HdMQTj9DK15/ZunjzadVS4KyNcRqNCNQRoQV0Q1Els9zxtV4Hgy7w8h+jl7voXkjaq3ozrhiYhRcJmcpbLq8HDX3tdd0T1xw8ukh+7v5SHuHyft70umGaMj5/U+E6nBvXEu6+nM6UKLGx4IsEEHYg2D6prW08wZRLaloAlAqJSUBClUtBARKUxKBQCoFEqIBCoiUEAhYOLR7JewbyryJH0WUoEoUwOw44FzfEGz80pZIATYf+7VGvO91sgJJX0FC2ee7FC9WuB4jLdeoUSvn1KCxspuss6BPI6m/M+3/ALSRPZQymxvYO45rB0kHNbYGZutkbjb+i2NmFGTB4i+K9Bj1zWCxNEDhYXrYefQHnt/fooD0kCsbZE6A1+kej454zHK0Oafdp/aaeB8VXvT3UyWC3wXiIgLI07VvmB8Q8tfDirK+fimWueOM+Z26TX5dK/Ie3boUWHAoqyusnU6PEEyQkQz7n/LkP7wGx8R62q3x+Dlgf2czDG4cHbEc2nYjUbLgyYpQe59lovEcWqXkupduv3FtTOFjFHYqUtR6BlD0wesTUbWSZGbmD6QliNxSvjP7riB6jYrvOrPWCZ8BkmqUiQRtIDWEim2TwPxclW9rtur8dYKPhmmBGpBP6VrdKIs6HT5FdOCTujxfF8WN4k3FW2lfU7M9LxDNmdky/EXaN4nfyaVuNkB2IPkbXI4sktnou1Y0ZtaAqSiKbbm3poLtZe0AlsW1zmFwJNd5uR1tG5+Mk6Udl2WfLS06rZ/lI6u0pK5rD9IzNbEM2a/0bzIdTKAWgG6ItwF7nvXS2o+ndHF8LwGki2d8lulOrkTYsEjumyEs1y081y3PZtG1qQY6J5yteM5GYMJpxbzAO48RotpU0tNcyFRAoIQKUqEoWgIohaBfX9EBCf8ApBoO53+QUHzUe5AB76C83F4hZMXiF57HZn6/CNTyvgFizJApx1GxUSPl13UWIs4/o7HyROIY6gNcpPd5HRe5H1wD+65pbYylwFtvnzXNTsp5vYAk+q18RiQAMgzECvBZl2rc7lrwac0gjfTY+K9DDSEBpOgo14mzf1XB9T8eWvdBI4U63x2dcx1c0eFa15rrmyEeWpHmsjE9uPEaX40FvRvtc/gsTehP96f0K9qKTSyoQ3AVK5LCyS9llDlSDArV6R6PinYY5WB7TtY1aebTwK2D4IZuajVmUZOLtbMrrp7qK9maTDHOwAuya9pW9AAa/nyXIPa5ji14LXDQteCHDzB1CvW15vTPQkGJbUrO9+GVtCRvk6vkdFy5NOnvE+g0Xj04VHOuJd+v3Kb7TwKIeug6wdUpsNb2XNBRJkAAcwXs9t+WoFeS50sC5JRlF0z6jBqMWeHFjdoyBysPAxlsOEjpuvZOJ7pOYXK7dwIojcA3rsq4jizODR+Iho0J1JrYan0VlPy/eGDOXvaHPFPncXMawNotbTWuzO0cKAusuq6NOubPJ8Yl5kfW/cvuEOa7tqIJOQdxuc5i12haBeaj8J29AozUwOq2vZlOvdNx2G/GNLbvR14jYyHaUkSkdpr2hkByiKyGu7nYjvfE7Tfe1jiy9lhzoDWG1LtdqphF2aJuj5irC6jw2vz2CGMmOVrc2Zr3FpJJ+INks6Pu3A0QCddKtbDyTKHhoLZGb5iO+W54g79mqdqAbvbRCP8AXStc0kdnG45u61xa91FoIIDacLFkGjoNjrSjLA19NPYudlyjP+rfmsODPhyACqG+4CCrdfm6+o3aAR0Hgdg/umR7SOzALzZD+7YLmW7wNA7buFxr2m2PLo3tbJGABlsklrR3S0Bw01dq7YtSSPqUDM4B47INvXQdo1zMney2XjUBxJ20Ws2EvaYv1bmuMkZL5pqiBJa7R7S8NdpRzUaTlyI1GS8r8/H2PZw/TTqcHxFz2HK5sTS0niHNbJVtob3uCNV6EePjdlAe0F4zMaXNzOHMC9R5Lk3TNDmzCMBr2vOILWRWxt05788luyH90tFuTSNMbXxOebaxszZHSRsMYvM+yGZQBpTgzNT62BVs0y00Xy2/Kfu+B2NpVyzOk5GHOXG2uDMRGXsdGxoYHOe0vc3gWEZaoP1BK9OHpijlmYI7Lw17XOdGcgs2XtaariAWnmrZzT004+k9VzkGjnukhe1wD2uDgdQ5pBbXgQnJVNBCVp4ufRNiZqXlTz6a81Gy0JK8k5Rufkg59DK3YWb5nmlidoTzv2FLC6T6fmsWUmdRediuloo3lj3U4VehO4B/NRQyo53HnvkcFgI09FFFuRhI0ekHZTG5ujgQQfEEUrHYbbryQUWPQnQXBnbzXoxyuzVemqiirB60e62WKKKEGamUUQGNvFZAoohQlcV1/wCiYWwuxDYw2YvjDnguF3obF1fjSKi1Zl5DO3w6co6mFOt18Tiug2g4mEEWO0YaOo0NhdgMU93SBiLj2bYpntGxDyQSQ4a8Bx202UUWrB5vtPo/E0nl3/sfzN3C9HQukxEbomOYHRvDXMB7xjY477660vO6RldFhMPJGcr3/dWOO9tYMzRR0AsIqLfJHi425Tinv5v+p7EkDWzRZbFw4g6Odoe445de7ZOtVay4DAsMk0Zz5Q5jhUsocC6NubvB1/NRRZI0OT4efT/o82UVGACQIsNBNGA53dkz1e+ug2OifpiIMMjmisuEme1pt0eZmUtPZnumi5x24qKLE6MbuaXpfyNbEANgmprQC3DOy5GFmaRozkMrKL8k+CeXRscfiyYR+YANdnfNke7MNbLSQTxsqKJ2L+lv0r4I3Y8BGMSWhtCVr3ykOcHPcyRuQl13pZ48Vo4qJgw75xGwTRyyNik7NmZgY/uhumlUEVFWka8cm2rfWPzR6oGTERhpcA9kxeC5zsxDoyCbPDM6uV0vUeVFFUcOb9Pq+bPMxjivMfwHigosWax5Dp/fMLCd/ZFRGDgsUc0j3O1Jc+yf4iooosTaf//Z" alt="">
                        <div class="flex flex-col justify-evenly">
                            <p class="text-xs">Stok: <span class="font-semibold">180 item</span></p>
                            <span class="p-0.5"></span>
                            <p class="text-xs">Kategori: <span class="font-semibold"><span>Makanan ringan,</span> <span>Makanan ringan,</span> <span>sedikit lagi expired</span></span></p>
                        </div>
                    </div>
                    <h3 class="text-xs font-bold">Wika Wiki Menyegarkan Menyegarkan Menyegarkan Menyegarkan</h4>
                    <p class="text-xs">Harga: <span class="font-semibold">Rp. 1.000.000,00</span></p>
                </div> --}}
            </div>
        </div>

        {{-- order div --}}
        <div class="flex flex-col p-3.5 border rounded-md border-red-500 justify-evenly gap-2 lg:w-[480px]">
            <h3 class="text-2xl font-bold">Order</h3>
            <div class="flex flex-col gap-2 max-h-[20rem] overflow-y-auto">
                <template x-for="(item, index) in $store.cart.items" :key="index">
                    <div class="flex flex-row border border-red-500 rounded-md shadow-md items-center p-1 select-none">
                        <img class="border border-red-500 rounded-md mr-1 object-cover h-[4rem] w-[4rem]" :src="'{{ asset("storage") }}/' + item.image" alt="">
                        <div class="flex flex-col justify-between grow self-stretch">
                            <h5 class="text-xs font-semibold mb-2" x-text="item.name"></h5>
                            <h6 class="text-xs font-semibold text-red-500" x-text="rupiah(item.price)"></h6>
                        </div>
                        <div class="flex flex-col justify-between self-stretch items-end w-48">
                            <h6 class="text-xs font-bold text-red-500" x-text="rupiah(item.total)"></h6>
                            <h6 class="flex flex-row gap-2 items-center text-sm font-bold mb-1">
                                <span class="p-1 px-2 rounded-full bg-red-500 text-white hover:cursor-pointer" x-on:click="$store.cart.add(item)">+</span> x<span x-text="item.quantity"></span> <span class="p-1 px-2.5 rounded-full bg-red-500 text-white hover:cursor-pointer" x-on:click="$store.cart.remove(item.id)">-</span>
                            </h6>
                        </div>
                    </div>
                </template>
                {{-- item shopping --}}
            </div>
            {{-- Perhitungan --}}
            <div class="flex flex-col justify-around gap-2 rounded-lg border border-red-500 bg-black-100 text-sm font-medium p-3">
                <div class="flex font-bold">
                    <span class="w-2/6">Subtotal</span>
                    <span class="w-1/6">:</span>
                    <span class="w-3/6" x-text="$store.cart.subtotal <= 0 ? 'Rp 0' : rupiah($store.cart.subtotal)"></span>
                </div>
            </div>
            <button 
                wire:click="mountAction('checkoutAction', { items: $store.cart.items.map(item => ({'item_id': item.id, 'item_quantity': item.quantity})) })"
                class="bg-red-500 text-white rounded-full py-1 text-lg font-bold"
            >
                Button
            </button>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/myapp.js') }}"></script>
    @endpush
</x-filament-panels::page>