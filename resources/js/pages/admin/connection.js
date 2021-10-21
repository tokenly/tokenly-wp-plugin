import Page from '/resources/js/pages/admin/page.js';

const { __ } = wp.i18n;

const {
	Button,
	Placeholder,
	Spinner,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

export default class ConnectionPage extends Page {
	authService;
	
	constructor( authService ) {
		super( ...arguments );
		this.authService = authService;
		this.state = {
			isAPILoaded: false,
			isAPISaving: false,
			status: false,
		};
	}

	getProps() {
		return new Promise( ( resolve, reject ) => {
			this.authService.getStatus().then( data => {
				resolve ( {
					...( data?.status ) && { status: data.status },
				} );
			} ).catch( error => {
				reject( error );
			});
		} );
	}
	
	getStatusText() {
		if ( this.state.status === true ) {
			return 'Connected';
		} else {
			return 'Not connected';
		}
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
									this.authService.connect();
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
									this.authService.disconnect();
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
 

