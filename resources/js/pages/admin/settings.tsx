import Page from './page';
import { Component } from 'react';

declare const wp: any;
declare const wpApiSettings: any;

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

export default class SettingsPage extends Component {
	constructor( props ) {
		super( props );
		this.updateSettings = this.updateSettings.bind( this );
		this.state = Object.assign( {
			clientId: null,
			clientSecret: null,
		}, this.state );
	}

	render() {


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
