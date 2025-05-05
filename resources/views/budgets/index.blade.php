                                            </div>
                                            <div class="text-right">
                                                <div class="text-xl font-bold">NRs {{ number_format($budget->amount, 2) }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <span>NRs {{ number_format($usedAmount, 2) }} spent</span>
                                                {{ __('Over budget by') }} NRs {{ number_format($usedAmount - $budget->amount, 2) }}
                                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                    NRs {{ number_format($budget->amount - $usedAmount, 2) }} {{ __('remaining') }}
                                                </div>
                                            </div> 