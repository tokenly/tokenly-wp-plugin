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
	render,
	Component,
	Fragment
} = wp.element;

class TokenpassSettingsPageComponent extends Component {
	constructor() {
		super( ...arguments );
		this.updateSettings = this.updateSettings.bind( this );
		this.state = {
			isAPILoaded: false,
			isAPISaving: false,
			clientId: null,
			clientSecret: null,
		};
	}

	componentDidMount() {
		wp.api.loadPromise.then( () => {
			if ( false === this.state.isAPILoaded ) {
				this.getSettings().then(result => {
					this.setState({
						isAPILoaded: true,
					});
				});
			}
		});
	}

	getSettings() {
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
					...( this.state.clientId ) && { 'client_id': this.state.clientId },
					...( this.state.clientSecret ) && { 'client_secret': this.state.clientSecret },
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
								<span> <b>APP HOMEPAGE URL: </b> <a href={appHomepageUrl} target="_blank">{appHomepageUrl}</a> </span><br/>
								<span> <b>CLIENT AUTHORIZATION REDIRECT URL: </b> <a href={clientAuthUrl} target="_blank">{clientAuthUrl}</a> </span>
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

export function init() {
	const postBody = document.querySelector( '#tokenpass-settings-page-content' );
	const appContainer = document.createElement( 'div' );
	postBody.appendChild( appContainer );
	
	render(
		<TokenpassSettingsPageComponent/>,
		appContainer
	);
}
 

