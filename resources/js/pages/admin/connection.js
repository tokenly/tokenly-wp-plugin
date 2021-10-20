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

class TokenpassConnectionPageComponent extends Component {
	constructor() {
		super( ...arguments );
		this.connect = this.connect.bind( this );
		this.state = {
			isAPILoaded: false,
			isAPISaving: false,
			status: false,
		};
	}

	componentDidMount() {
		wp.api.loadPromise.then( () => {
			if ( false === this.state.isAPILoaded ) {
				this.getStatus().then(result => {
					this.setState({
						isAPILoaded: true,
					});
				});
			}
		});
	}

	getStatus() {
		return new Promise((resolve, reject) => {
			const params = {
				method: 'GET',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = '/wp-json/tokenly/v1/authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					console.log(data);
					this.setState( {
						...(data?.status) && {status: data.status},
					} );
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
	
	getStatusText() {
		if ( this.state.status === true ) {
			return 'Connected';
		} else {
			return 'Not connected';
		}
	}

	connect() {
		return new Promise((resolve, reject) => {
			const params = {
				method: 'POST',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = '/wp-json/tokenly/v1/authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					const redirectUrl = data.url ?? null;
					if (redirectUrl) {
						window.location = redirectUrl;
					}	
				} )
				.catch( err => reject( err ) );
		});
	}
	
	disconnect() {
		return new Promise((resolve, reject) => {
			const params = {
				method: 'DELETE',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = '/wp-json/tokenly/v1/authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					window.location.reload( false );
				} )
				.catch( err => reject( err ) );
		});
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
				<h2>Connection</h2> 
				<Panel header="Connection Status">
					<PanelBody>
						<PanelRow>
							<div>
								<span>Connection status: </span><span><strong>{this.getStatusText()}</strong></span>
							</div>
						</PanelRow>
						<PanelRow>
							<Button
								isPrimary
								isLarge
								disabled={ this.state.status }
								onClick={ () => {
									this.connect();
								}}
							>
								{ __( 'Connect to Tokenpass' ) }
							</Button>
						</PanelRow>
						<PanelRow>
							<Button
								isPrimary
								isLarge
								disabled={ !this.state.status }
								onClick={ () => {
									this.disconnect();
								}}
							>
								{ __( 'Disconnect from Tokenpass' ) }
							</Button>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Fragment>
		);
	}
}

export function init() {
	const postBody = document.querySelector('#tokenpass-connection-page-content');
	if ( postBody ) {
		const appContainer = document.createElement( 'div' );
		postBody.appendChild( appContainer );
		
		render(
			<TokenpassConnectionPageComponent/>,
			appContainer
		);
	}
}
 

