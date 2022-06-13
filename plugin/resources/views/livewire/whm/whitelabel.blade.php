<div>
        <form id="contactForm" data-sb-form-api-token="API_TOKEN">

            <div class="mb-3">
                <label class="form-label" for="brandName">Brand Name</label>
                <input class="form-control" id="brandName" wire:model="state.wl_brand_name" type="text" placeholder="Brand Name" data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="brandFavicon">Brand Favicon</label>
                <input class="form-control" id="brandFavicon" wire:model="state.wl_brand_favicon" type="text" placeholder="Brand Favicon" data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="adminLoginWhiteLabelUrl">Admin login - White Label URL?</label>
                <input class="form-control" id="adminLoginWhiteLabelUrl" wire:model="state.wl_admin_login_url" type="text" placeholder="Admin login - White Label URL?" data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="enableSupportLinks">Enable support links?</label>
                <input class="form-control" id="enableSupportLinks" wire:model="state.wl_contact_page" type="text" placeholder="Enable support links?" data-sb-validations="" />
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="enableSupportLinks" wire:model="state.wl_enable_support_links" type="checkbox" name="enableSupportLinks" />
                    <label class="form-check-label" for="enableSupportLinks">Enable support links</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="enterPoweredByText">Enter &quot;Powered by&quot; text </label>
                <textarea class="form-control" id="enterPoweredByText" wire:model="state.wl_powered_by_link" type="text" placeholder='Enter "Powered by" text ' style="height: 10rem;" data-sb-validations=""></textarea>
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="hidePoweredByLink" wire:model="state.wl_hide_powered_by_link" type="checkbox" name="hidePoweredByLink" />
                    <label class="form-check-label" for="hidePoweredByLink">Hide &quot;Powered by&quot; link </label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="logoForAdminPanelSize180X35Px">Logo for Admin panel (size: 180x35px) </label>
                <input class="form-control" id="logoForAdminPanelSize180X35Px" wire:model="state.wl_logo_admin_panel" type="text" placeholder="Logo for Admin panel (size: 180x35px) " data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="logoForLiveEditToolbarSize50X50Px">Logo for Live-Edit toolbar (size: 50x50px) </label>
                <input class="form-control" id="logoForLiveEditToolbarSize50X50Px" wire:model="state.wl_logo_live_edit_toolbar" type="text" placeholder="Logo for Live-Edit toolbar (size: 50x50px) " data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="logoForLoginScreenMaxWidth290Px">Logo for Login screen (max width: 290px) </label>
                <input class="form-control" id="logoForLoginScreenMaxWidth290Px" wire:model="state.wl_logo_login_screen" type="text" placeholder="Logo for Login screen (max width: 290px) " data-sb-validations="" />
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="disableMicroweberMarketplace" wire:model="state.wl_disable_microweber_marketplace" type="checkbox" name="disableMicroweberMarketplace" />
                    <label class="form-check-label" for="disableMicroweberMarketplace"> Disable Microweber Marketplace </label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="externalLoginServerButtonText">External Login Server Button Text </label>
                <input class="form-control" id="externalLoginServerButtonText" wire:model="state.wl_external_login_server_button_text" type="text" placeholder="External Login Server Button Text " data-sb-validations="" />
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="enableExternalLoginServer" wire:model="state.wl_external_login_server_enable" type="checkbox" name="enableExternalLoginServer" />
                    <label class="form-check-label" for="enableExternalLoginServer">Enable External Login Server </label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="enableMicroweberServiceLinks" wire:model="state.wl_enable_service_links" type="checkbox" name="enableMicroweberServiceLinks" />
                    <label class="form-check-label" for="enableMicroweberServiceLinks">Enable Microweber Service Links</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="cpanelLogoForSidebar">Cpanel Logo for sidebar</label>
                <input class="form-control" id="cpanelLogoForSidebar" wire:model="state.wl_cpanel_logo_invert" type="text" placeholder="Cpanel Logo for sidebar" data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="cpanelLogoApp">Cpanel Logo App</label>
                <input class="form-control" id="cpanelLogoApp" wire:model="state.wl_cpanel_logo_app" type="text" placeholder="Cpanel Logo App" data-sb-validations="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="enterAdminColorsSass">Enter &quot;Admin colors&quot; sass</label>
                <textarea class="form-control" id="enterAdminColorsSass" wire:model="state.wl_admin_colors_sass" type="text" placeholder='Enter "Admin colors" sass' style="height: 10rem;" data-sb-validations=""></textarea>
            </div>

        </form>
</div>