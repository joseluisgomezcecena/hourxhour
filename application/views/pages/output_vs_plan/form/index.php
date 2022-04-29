<div class="grid lg:grid-cols-1 gap-5">
    <div class="grid sm:grid-cols-3 gap-5 my-5">
        <div class="card p-5">
            <form class="relative mt-5">
                <label class="label absolute block bg-input top-0 ltr:ml-3 rtl:mr-3 px-1 rounded font-heading uppercase" for="input-1">Screen name</label>
                <input id="input-1" type="text" class="form-control mt-2 pt-5" placeholder="Enter screen name here">
                <div style="margin-top:1rem; display:flex; justify-content:flex-end;">
                    <button type="button" class="btn btn_success uppercase">Add Screen</button>
                </div>
            </form>
        </div>
    </div>
    <div class="grid sm:grid-cols-3 gap-5 my-5">
        <div class="card p-5" >
        <span class="icon las la-trash" style="display: flex; justify-content:flex-end; font-size:2rem"></span>
            <h3 class="uppercase text-center">Screen number 1</h3>
            <form class="relative mt-5">
                <div class="input-group mt-5">
                    <select type="text" class="form-control input-group-item" placeholder="Input">
                        <option value="1">value 1</option>
                    </select>
                    <button class="btn btn_primary uppercase input-group-item"><span class="icon las la-plus text-danger"></span></button>
                </div>
            </form>
            <div class="mt-4">
                <table>
                    <table class="table w-full mt-3 text-center">
                        <thead>
                            <tr>
                                <th class="text-center uppercase">
                                    <h5 style="color: black;">TIP 32</h5>
                                </th>
                                <th class="text-center uppercase"></th>
                                <th class="text-center uppercase"><button type="button" class="btn btn-icon btn-icon_large btn_danger uppercase">
                                        <span class="icon las la-trash"></span>
                                    </button>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center uppercase">
                                    <h5 style="color: black;">BOY 25</h5>
                                </th>
                                <th class="text-center uppercase"></th>
                                <th class="text-center uppercase"><button type="button" class="btn btn-icon btn-icon_large btn_danger uppercase">
                                        <span class="icon las la-trash"></span>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                    </table>
            </div>
        </div>
    </div>
</div>