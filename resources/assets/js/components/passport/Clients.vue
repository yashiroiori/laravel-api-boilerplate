<template>
    <div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">{{ $t('auth.oauth_clients.title') }}</h3>
						<a class="action-link pull-right" @click="showCreateClientForm">
							{{ $t('auth.oauth_clients.create_new_client') }}
						</a>
					</div>
					<div class="box-body">
						<p class="m-b-none" v-if="clients.length === 0">
							{{ $t('auth.oauth_clients.no_client_yet') }}
						</p>
						<div class="dataTables_wrapper form-inline dt-bootstrap" v-if="clients.length > 0">
							<div class="row">
								<div class="col-sm-6">
									<div class="dataTables_length">

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 table-responsive">
									<table aria-describedby="example1_info" role="grid" class="table table-bordered table-striped dataTable">
										<thead>
										<tr role="row">
											<th>{{ $t('auth.oauth_clients.client_id') }}</th>
											<th>{{ $t('auth.oauth_clients.client_name') }}</th>
											<th>{{ $t('auth.oauth_clients.client_secret') }}</th>
											<th></th>
										</tr>
										</thead>
										<tbody>

										<tr v-for="client in clients" role="row">
											<!-- ID -->
											<td class="col-md-2" style="vertical-align: middle;">
												{{ client.id }}
											</td>

											<!-- Name -->
											<td class="col-md-2" style="vertical-align: middle;">
												{{ client.name }}
											</td>

											<!-- Secret -->
											<td class="col-md-2" style="vertical-align: middle;">
												<code>{{ client.secret }}</code>
											</td>

											<td class="col-md-2 text-right" style="vertical-align: middle;">
												<a class="action-link btn btn-default" @click="edit(client)">
													{{ $t('auth.oauth_clients.edit_btn') }}
												</a>
												<a class="btn btn-danger action-link" @click="destroy(client)">
													{{ $t('auth.oauth_clients.delete_btn') }}
												</a>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-create-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
							{{ $t('auth.oauth_create_client_modal.title') }}
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p>{{ $t('auth.oauth_create_client_modal.error') }}</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('auth.oauth_create_client_modal.name') }}</label>

                                <div class="col-md-7">
                                    <input id="create-client-name" type="text" class="form-control"
                                                                @keyup.enter="store" v-model="createForm.name">

                                    <span class="help-block">
										{{ $t('auth.oauth_create_client_modal.name_help') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('auth.oauth_create_client_modal.redirect_url') }}</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="redirect"
                                                    @keyup.enter="store" v-model="createForm.redirect">

                                    <span class="help-block">
                                        {{ $t('auth.oauth_create_client_modal.redirect_url_help') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('auth.oauth_create_client_modal.close_btn') }}</button>

                        <button type="button" class="btn btn-primary" @click="store">
							{{ $t('auth.oauth_create_client_modal.create_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Client Modal -->
        <div class="modal fade" id="modal-edit-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
							{{ $t('auth.oauth_edit_client_modal.title') }}
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p>{{ $t('auth.oauth_edit_client_modal.error') }}</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('auth.oauth_edit_client_modal.name') }}</label>

                                <div class="col-md-7">
                                    <input id="edit-client-name" type="text" class="form-control"
                                                                @keyup.enter="update" v-model="editForm.name">

                                    <span class="help-block">
                                        {{ $t('auth.oauth_edit_client_modal.name_help') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('auth.oauth_edit_client_modal.redirect_url') }}</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="redirect"
                                                    @keyup.enter="update" v-model="editForm.redirect">

                                    <span class="help-block">
                                        {{ $t('auth.oauth_edit_client_modal.redirect_url_help') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('auth.oauth_edit_client_modal.close_btn') }}</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            {{ $t('auth.oauth_edit_client_modal.save_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
				loading_clients: true,

                clients: [],

                createForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getClients();

                $('#modal-create-client').on('shown.bs.modal', () => {
                    $('#create-client-name').focus();
                });

                $('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-client-name').focus();
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
				this.loading_clients = true;
                oauthAxios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
							this.loading_tokens = false;
                        }).catch(error => {
							this.$root.axiosError(error);
						});
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                $('#modal-create-client').modal('show');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm, '#modal-create-client'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;

                $('#modal-edit-client').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm, '#modal-edit-client'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                oauthAxios[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
							this.$root.axiosError(error);
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                oauthAxios.delete('/oauth/clients/' + client.id)
					.then(response => {
						this.getClients();
					}).catch(error => {
						this.$root.axiosError(error);
					});
            }
        }
    }
</script>
