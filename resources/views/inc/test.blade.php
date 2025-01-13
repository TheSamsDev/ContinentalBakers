<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl-12 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-12">
                        <div id="map" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{ asset('app-assets/assets/img/icons/unicons/chart-success.png') }}"
                      alt="chart success"
                      class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt3"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
                <p class="mb-1">Profit</p>
                <h4 class="card-title mb-3">$12,628</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{ asset('app-assets/assets/img/icons/unicons/wallet-info.png') }}"
                      alt="wallet info"
                      class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt6"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                      <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                    </div>
                  </div>
                </div>
                <p class="mb-1">Sales</p>
                <h4 class="card-title mb-3">$4,679</h4>
                <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
        <!-- Total Revenue -->
        <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
          <div class="card">
              <div class="row row-bordered g-0">
                  <div class="col-lg-8">
                      <div class="card-header d-flex align-items-center justify-content-between">
                          <div class="card-title mb-0">
                              <h5 class="m-0 me-2">Total Revenue & Orders</h5>
                          </div>
                          <div class="dropdown">
                              <button class="btn p-0" type="button" id="totalRevenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="bx bx-dots-vertical-rounded bx-lg text-muted"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalRevenue">
                                  <a class="dropdown-item" href="javascript:void(0);" id="toggleRevenue">Revenue</a>
                                  <a class="dropdown-item" href="javascript:void(0);" id="toggleOrders">Orders</a>
                                  <a class="dropdown-item" href="javascript:void(0);" id="toggleBoth">Both</a>
                              </div>
                          </div>
                      </div>
                      <canvas id="totalRevenueChart" class="px-3"></canvas>
                  </div>
                  <div class="col-lg-4 d-flex align-items-center">
                    <div class="card-body px-xl-9">
                      <div class="text-center mb-6">
                        <div class="btn-group">
                            <button
                                id="selectedYearButton"
                                type="button"
                                class="btn btn-outline-primary">
                                <!-- Default to current year -->
                                <script>document.write(new Date().getFullYear());</script>
                            </button>
                            <button
                                type="button"
                                class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul id="yearDropdown" class="dropdown-menu">
                                <!-- Dynamic years will be added here -->
                            </ul>
                        </div>
                        
                      </div>
                  
                      <div id="growthChartContainer">
                        <canvas id="growthChart" style="width: 100%; height: 500px;"> </canvas>
                      </div>
                      <div class="text-center fw-medium my-6">
                        <span id="growthPercentage">0%</span> Company Growth
                      </div>
                  
                      <div class="d-flex gap-3 justify-content-between">
                        <div class="d-flex">
                          <div class="avatar me-2">
                            <span class="avatar-initial rounded-2 bg-label-primary"
                              ><i class="bx bx-dollar bx-lg text-primary"></i
                            ></span>
                          </div>
                          <div class="d-flex flex-column">
                            <small id="currentYearSalesLabel">{{ date('Y') }}</small>

                            <h6 class="mb-0" id="currentYearSales">$0</h6>
                          </div>
                        </div>
                        <div class="d-flex">
                          <div class="avatar me-2">
                            <span class="avatar-initial rounded-2 bg-label-info"
                              ><i class="bx bx-wallet bx-lg text-info"></i
                            ></span>
                          </div>
                          <div class="d-flex flex-column">
                            <small id="previousYearSalesLabel">{{ date('Y') - 1 }}</small>

                            <h6 class="mb-0" id="previousYearSales">$0</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
      
        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2">
            <div class="row">
                <div class="col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('app-assets/assets/img/icons/unicons/paypal.png') }}"
                                        alt="paypal" class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Payments</p>
                            <h4 class="card-title mb-3">$2,456</h4>
                            <small class="text-danger fw-medium"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('app-assets/assets/img/icons/unicons/cc-primary.png') }}"
                                        alt="Credit Card" class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Transactions</p>
                            <h4 class="card-title mb-3">$14,857</h4>
                            <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-6">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title mb-6">
                                        <h5 class="text-nowrap mb-1">Profile Report</h5>
                                        <span class="badge bg-label-warning">YEAR 2022</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <span class="text-success text-nowrap fw-medium"><i
                                                class="bx bx-up-arrow-alt"></i> 68.2%</span>
                                        <h4 class="mb-0">$84,686k</h4>
                                    </div>
                                </div>
                                <div id="profileReportChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Order Statistics -->
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">Order Statistics</h5>
                        <p class="card-subtitle">${{ number_format($overallSales->total_sales / 1_000_000, 2) }}M Total
                            Sales</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="orderStatistics"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orderStatistics">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h3 class="mb-1">{{ $overallSales->total_orders }}</h3>
                            <small>Total Orders</small>
                        </div>
                        <div id="orderStatisticsChart"></div>
                    </div>
                    <ul class="p-0 m-0">
                        @foreach ($topBrands as $brand)
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary" data-bs-toggle="modal"
                                        data-bs-target="#brandDetailsModal" data-brand="{{ $brand->brand_name }}"
                                        data-products="{{ $brand->product_names }}"
                                        data-orders="{{ $brand->total_orders }}"
                                        data-logo="{{ asset('storage/' . $brand->logo) }}"
                                        data-sales="{{ number_format($brand->total_sales / 1_000_000, 2) }}">
                                        <i class="bx bx-tag"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $brand->brand_name }}</h6>
                                        <small>
                                            {{ Str::limit($brand->product_names, 30, '...') }}
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">${{ number_format($brand->total_sales / 1_000_000, 2) }}M
                                        </h6>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="brandDetailsModal" tabindex="-1" aria-labelledby="brandDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="brandDetailsModalLabel">Brand Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Brand Info Section -->
                            <div class="col-md-6 text-center">
                                <img src="/storage/brands/default.jpg" alt="Brand Logo"
                                    id="modalSalesmodalSalesmodalSales" class="img-fluid ">
                                <h5 id="modalBrandName">Brand Name</h5>
                                <p><strong>Total Sales:</strong> $<span id="modalSales">0</span>M</p>
                                <p><strong>Total Orders:</strong> <span id="modalOrders">0</span></p>
                            </div>

                            <!-- Products Section -->
                            <div class="col-md-6">
                                <h6>Products</h6>
                                <div id="productsGrid" class="row g-2">
                                    <!-- Dynamic Product Cards Will Appear Here -->
                                    <p>Loading products...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-4 order-1 mb-6">
            <div class="card h-100">
                <div class="card-header nav-align-top">
                    <h5 class="card-title m-0 me-2">Top  Store </h5>

                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            @foreach ($topStore as $store)

                            <div class="d-flex mb-6">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('app-assets/assets/img/icons/unicons/wallet.png') }}"
                                        alt="User" />
                                </div>
                                <div>
                                    <p class="mb-0">{{ $store->store_name ?? 'NO Store' }}</p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1">
                                            ${{ number_format($store->total_sales / 1_000_000, 2) }}M</h6>
                                        <small class="text-success fw-medium">
                                            <i class="bx bx-chevron-up bx-lg"></i>
                                            42.9%
                                        </small>
                                    </div>   
                                   
                                </div>
                            </div>
                            @endforeach

                            <h5 class="card-title m-0 me-2">Last Store Order </h5>
                            @foreach ($allStores as $store)

                            <div class="d-flex mb-6">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('app-assets/assets/img/icons/unicons/wallet.png') }}"
                                        alt="User" />
                                </div>
                                <div>
                                  <p class="mb-0">{{ $store->store_name }}</p>
                                  <div class="d-flex align-items-center">
                                      <h6 class="mb-0 me-1">
                                          ${{ number_format($store->total_sales / 1_000_000, 2) }}M
                                      </h6>
                                      <small class="text-success fw-medium">
                                          <!-- Use Carbon's diffForHumans to show relative date -->
                                          <i class="bx bx-chevron-up bx-lg"></i>
                                          {{ \Carbon\Carbon::parse($store->last_order_date)->diffForHumans(null, true) }}
                                      </small>
                                  </div>
                              </div>
                              
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->

        <!-- Transactions -->
        <div class="col-md-6 col-lg-4 order-2 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Top Products </h5>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="transactionID"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <ul class="p-0 m-0">
                        @foreach ($topProducts as $product)
                            <li class="d-flex align-items-center mb-6">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="User"
                                        class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="d-block">{{ $product->product_name }}</small>
                                        <h6 class="fw-normal mb-0">Quantity: {{ $product->total_quantity }}</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="fw-normal mb-0">
                                            ${{ number_format($product->total_sales / 1_000_000, 2) }}M</h6>
                                        <span class="text-muted">USD</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
</div>
