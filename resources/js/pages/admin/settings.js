import Page from '/resources/js/pages/admin/page.js';

const { __ } = wp.i18n;

const {
	Button,
	TextControl,
	Placeholder,
	Spinner,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

const {
	Component,
	Fragment
} = wp.element;

export default class SettingsPage extends Page {
	constructor( props ) {
		super( props );
		this.updateSettings = this.updateSettings.bind( this );
		this.state = Object.assign( {
			clientId: null,
			clientSecret: null,
		}, this.state );
	}

	getProps() {
		return new Promise((resolve, reject) => {
			const params = {
				method: 'GET',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = '/wp-json/tokenly/v1/settings';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					console.log(data);
					this.setState( {
						...(data?.client_id) && {clientId: data.client_id},
						...(data?.client_secret) && {clientSecret: data.client_secret},
					} );
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}

	updateSettings() {
		this.setState( { isAPISaving: true } );
		const params = {
			method: 'PUT',
			headers: {
				'Content-type': 'application/json; charset=UTF-8',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify( {
				settings: {
					...{ 'client_id': this.state.clientId ?? '' },
					...{ 'client_secret': this.state.clientSecret ?? '' },
				}
			} ),
		 }
		 const url = '/wp-json/tokenly/v1/settings';
		 fetch( url, params )
			.then( response => response.json() )
			.then( data => {
				this.setState( {
					isAPISaving: false
				} ) } )
			.catch( err => console.log( err ) );
	}

	render() {
		if ( ! this.state.isAPILoaded ) {
			return (
				<Placeholder>
					<Spinner/>
				</Placeholder>
			);
		}

		return (
			<Fragment>
				<h2>Tokenpass Settings</h2> 
				<Panel header="How to Setup">
					<PanelBody>
						<PanelRow>
							<ul class='tk_steps'>
								<li>1. Create App on <a href="https://tokenpass.tokenly.com/auth/apps" target="_blank">Tokenpass Developers</a></li>
								<li>2. Use below details to create App</li>
							</ul>
						</PanelRow>
						<PanelRow>
							<div class='tk_app_details'>
								<h3>Register Client Application</h3>
								<span> <b>CLIENT NAME: </b> Random Input </span><br/>
								<span> <b>APP HOMEPAGE URL: </b> <a href={this.state.props.app_homepage_url} target="_blank">{this.state.props.app_homepage_url}</a> </span><br/>
								<span> <b>CLIENT AUTHORIZATION REDIRECT URL: </b> <a href={this.state.props.client_auth_url} target="_blank">{this.state.props.client_auth_url}</a> </span>
							</div>
						</PanelRow>
						<PanelRow className="api-input-container">
							<TextControl
								label="Client ID"
								value={ this.state.clientId }
								onChange={ ( value ) => {
									this.setState({clientId: value});
									}
								}
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Client Secret"
								value={ this.state.clientSecret }
								onChange={ ( value ) => {
										this.setState({clientSecret: value});
									}
								}
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow className="save-button-container">
							<Button
								isPrimary
								isLarge
								disabled={ this.state.isAPISaving }
								onClick={ () => {
									this.updateSettings();
								}}
							>
								{ __( 'Save settings' ) }
							</Button>
							{this.state.isAPISaving === true &&
									<Spinner/>
							}
						</PanelRow>
					</PanelBody>
				</Panel>
			</Fragment>
		);
	}
}
