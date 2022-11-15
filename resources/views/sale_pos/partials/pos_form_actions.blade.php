@php
	$is_mobile = isMobile();
@endphp
<div class="row pos-form-actions">
	<div class="col-md-6 pos_form_totals">
		<table class="table table-condensed">
			<tr>
				<td><b>@lang('sale.item'):</b>&nbsp;
					<span class="total_quantity">0</span></td>
				<td>
					<b>@lang('sale.subtotal'):</b> &nbsp;
					<span class="price_total">0</span>
				</td>
				<td>
					<span>
						<b>Note (+): @show_tooltip(__('tooltip.sale_tax'))</b>
						<i class="fas fa-edit cursor-pointer" title="note" aria-hidden="true" data-toggle="modal" data-target="#posWriteNote" ></i> 
					</span>
				</td>

			</tr>
			<tr class="custom-tr-border"></tr>
			<tr>
				<td>
					<b>
						@if($is_discount_enabled)
							@lang('sale.discount')
							@show_tooltip(__('tooltip.sale_discount'))
						@endif
						@if($is_rp_enabled)
							{{session('business.rp_name')}}
						@endif
						@if($is_discount_enabled)
							(-):
							@if($edit_discount)
							<i class="fas fa-edit cursor-pointer" id="pos-edit-discount" title="@lang('sale.edit_discount')" aria-hidden="true" data-toggle="modal" data-target="#posEditDiscountModal"></i>
							@endif
						
							<span id="total_discount">0</span>
						@endif
							<input type="hidden" name="discount_type" id="discount_type" value="@if(empty($edit)){{'percentage'}}@else{{$transaction->discount_type}}@endif" data-default="percentage">

							<input type="hidden" name="discount_amount" id="discount_amount" value="@if(empty($edit)) {{@num_format($business_details->default_sales_discount)}} @else {{@num_format($transaction->discount_amount)}} @endif" data-default="{{$business_details->default_sales_discount}}">

							<input type="hidden" name="rp_redeemed" id="rp_redeemed" value="@if(empty($edit)){{'0'}}@else{{$transaction->rp_redeemed}}@endif">

							<input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="@if(empty($edit)){{'0'}}@else {{$transaction->rp_redeemed_amount}} @endif">

							</span>
					</b> 
				</td>
				<td class="@if($pos_settings['disable_order_tax'] != 0) hide @endif">
					<span>
						<b>@lang('sale.order_tax')(+): @show_tooltip(__('tooltip.sale_tax'))</b>
						<i class="fas fa-edit cursor-pointer" title="@lang('sale.edit_order_tax')" aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax" ></i> 
						<span id="order_tax">
							@if(empty($edit))
								0
							@else
								{{$transaction->tax_amount}}
							@endif
						</span>

						<input type="hidden" name="tax_rate_id" 
							id="tax_rate_id" 
							value="@if(empty($edit)) {{$business_details->default_sales_tax}} @else {{$transaction->tax_id}} @endif" 
							data-default="{{$business_details->default_sales_tax}}">

						<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
							value="@if(empty($edit)) {{@num_format($business_details->tax_calculation_amount)}} @else {{@num_format(optional($transaction->tax)->amount)}} @endif" data-default="{{$business_details->tax_calculation_amount}}">

					</span>
				</td>
				<td>
					<span>

						<b>@lang('sale.shipping')(+): @show_tooltip(__('tooltip.shipping'))</b> 
						<i class="fas fa-edit cursor-pointer"  title="@lang('sale.shipping')" aria-hidden="true" data-toggle="modal" data-target="#posShippingModal"></i>
						<span id="shipping_charges_amount">0</span>
						<input type="hidden" name="shipping_details" id="shipping_details" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_details}}@endif" data-default="">

						<input type="hidden" name="shipping_address" id="shipping_address" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_address}}@endif">

						<input type="hidden" name="shipping_status" id="shipping_status" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_status}}@endif">

						<input type="hidden" name="delivered_to" id="delivered_to" value="@if(empty($edit)){{''}}@else{{$transaction->delivered_to}}@endif">

						<input type="hidden" name="shipping_charges" id="shipping_charges" value="@if(empty($edit)){{@num_format(0.00)}} @else{{@num_format($transaction->shipping_charges)}} @endif" data-default="0.00">
					</span>
				</td>
				@if(in_array('types_of_service', $enabled_modules))
					<td class="col-sm-3 col-xs-6 d-inline-table">
						<b>@lang('lang_v1.packing_charge')(+):</b>
						<i class="fas fa-edit cursor-pointer service_modal_btn"></i> 
						<span id="packing_charge_text">
							0
						</span>
					</td>
				@endif
				@if(!empty($pos_settings['amount_rounding_method']) && $pos_settings['amount_rounding_method'] > 0)
				<td>
					<b id="round_off">@lang('lang_v1.round_off'):</b> <span id="round_off_text">0</span>								
					<input type="hidden" name="round_off_amount" id="round_off_amount" value=0>
				</td>
				@endif
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		@if($is_mobile)
			<div class="col-md-12 text-right">
				<b>@lang('sale.total_payable'):</b>
				<input type="hidden" name="final_total" 
											id="final_total_input" value=0>
				<span id="total_payable" class="text-success lead text-bold text-right">0</span>
			</div>
		@endif
		<!-- <button type="button" class="@if($is_mobile) col-xs-6 @endif btn bg-info text-white btn-default btn-flat @if($pos_settings['disable_draft'] != 0) hide @endif" id="pos-draft"><i class="fas fa-edit"></i> @lang('sale.draft')</button> -->
		<button type="button" class="btn btn-default bg-yellow btn-flat @if($is_mobile) col-xs-6 @endif" id="pos-quotation"><i class="fas fa-edit"></i> @lang('lang_v1.quotation')</button>

		{{-- @if(empty($pos_settings['disable_suspend']))
			<!-- <button type="button" 
			class="@if($is_mobile) col-xs-6 @endif btn bg-red btn-default btn-flat no-print pos-express-finalize" 
			data-pay_method="suspend"
			title="@lang('lang_v1.tooltip_suspend')" >
			<i class="fas fa-pause" aria-hidden="true"></i>
			@lang('lang_v1.suspend')
			</button> -->
		@endif --}}

		@if(empty($pos_settings['disable_credit_sale_button']))
			<input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
			<button type="button" 
			class="btn bg-purple btn-default btn-flat no-print pos-express-finalize @if($is_mobile) col-xs-6 @endif" 
			data-pay_method="credit_sale"
			title="@lang('lang_v1.tooltip_credit_sale')" >
				<i class="fas fa-check" aria-hidden="true"></i> @lang('lang_v1.credit_sale')
			</button>
		@endif
		<button type="button" 
			class="btn bg-maroon btn-default btn-flat no-print @if(!empty($pos_settings['disable_suspend'])) @endif pos-express-finalize @if(!array_key_exists('card', $payment_types)) hide @endif @if($is_mobile) col-xs-6 @endif" 
			data-pay_method="card"
			title="@lang('lang_v1.tooltip_express_checkout_card')" >
			<i class="fas fa-credit-card" aria-hidden="true"></i> @lang('lang_v1.express_checkout_card')
		</button>

		<!-- <button type="button" class="btn bg-navy btn-default @if(!$is_mobile) @endif btn-flat no-print @if($pos_settings['disable_pay_checkout'] != 0) hide @endif @if($is_mobile) col-xs-6 @endif" id="pos-finalize" title="@lang('lang_v1.tooltip_checkout_multi_pay')"><i class="fas fa-money-check-alt" aria-hidden="true"></i> @lang('lang_v1.checkout_multi_pay') </button> -->

		<button type="button" class="btn btn-success @if(!$is_mobile) @endif btn-flat no-print @if($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)) hide @endif pos-express-finalize @if($is_mobile) col-xs-6 @endif" data-pay_method="cash" title="@lang('tooltip.express_checkout')"> <i class="fas fa-money-bill-alt" aria-hidden="true"></i> @lang('lang_v1.express_checkout_cash')</button>

		@if(empty($edit))
			<button type="button" class="btn btn-danger btn-flat @if($is_mobile) col-xs-6 @endif" id="pos-cancel"> <i class="fas fa-window-close"></i> @lang('sale.cancel')</button>
		@else
			<button type="button" class="btn btn-danger btn-flat hide @if($is_mobile) col-xs-6 @endif" id="pos-delete"> <i class="fas fa-trash-alt"></i> @lang('messages.delete')</button>
		@endif

		@if(!$is_mobile)
		<div class="bg-navy pos-total text-white">
		<span class="text">@lang('sale.total_payable')</span>
		<input type="hidden" name="final_total" 
									id="final_total_input" value=0>
		<span id="total_payable" class="number">0</span>
		</div>
		@endif

		@if(!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0)
		<!-- <button type="button" class="pull-right btn btn-primary btn-flat @if($is_mobile) col-xs-6 @endif" data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions"> <i class="fas fa-clock"></i> @lang('lang_v1.recent_transactions')</button> -->
		@endif

		
		
	</div>
</div>
@if(isset($transaction))
	@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $transaction->discount_amount, 'discount_type' => $transaction->discount_type, 'rp_redeemed' => $transaction->rp_redeemed, 'rp_redeemed_amount' => $transaction->rp_redeemed_amount, 'max_available' => !empty($redeem_details['points']) ? $redeem_details['points'] : 0])
@else
	@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $business_details->default_sales_discount, 'discount_type' => 'percentage', 'rp_redeemed' => 0, 'rp_redeemed_amount' => 0, 'max_available' => 0])
@endif

@if(isset($transaction))
	@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
	@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $business_details->default_sales_tax])
@endif

@include('sale_pos.partials.edit_shipping_modal')
@include('sale_pos.partials.write_note_modal')