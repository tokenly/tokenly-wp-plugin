import * as React from 'react';
import { Component } from 'react';
import { ConfirmModal } from '../Admin/Components/ConfirmModal';
import TcaRuleEditor from './../Admin/Components/TcaRuleEditor';
import { ConfirmModalData } from '../Interfaces';
import eventBus from "../EventBus";

import { 
	Fragment,
} from '@wordpress/element';

interface AppLayoutProps {
	children: any;
	tcaEnabled: boolean;
	tcaRules: any;
}

interface AppLayoutState {
	confirmModalData: ConfirmModalData;
	confirmModalShow: boolean;
	postData: any;
	tcaRules: []
}

export default class AppLayout extends Component<AppLayoutProps, AppLayoutState> {
	state: AppLayoutState = {
		confirmModalData: null,
		confirmModalShow: false,
		postData: {},
		tcaRules: []
	};
	constructor( props: AppLayoutProps ) {
		super( props );
		this.onConfirmModalShow = this.onConfirmModalShow.bind( this );
		this.onConfirmModalRequestClose = this.onConfirmModalRequestClose.bind( this );
		this.onConfirmModalChoice = this.onConfirmModalChoice.bind( this );
		this.onTcaUpdate = this.onTcaUpdate.bind( this );
		this.state.tcaRules = Object.assign( {}, this.props.tcaRules );
		console.log(this.state.tcaRules);
	}

	onConfirmModalRequestClose() {
		this.setState( {
			confirmModalData: null,
			confirmModalShow: false,
		} );
	}

	onConfirmModalChoice( choice: string ) {
		eventBus.dispatch( 'confirmModalChoice', {
			key: this.state?.confirmModalData?.key,
			choice: choice,
		} );
		this.onConfirmModalRequestClose();
	}

	onConfirmModalShow( confirmModalData: ConfirmModalData ) {
		this.setState( {
			confirmModalData: confirmModalData,
			confirmModalShow: true,
		} );
	}

	componentDidMount() {
		eventBus.on( 'confirmModalShow', this.onConfirmModalShow );
	}
	
	componentWillUnmount() {
		eventBus.remove( 'confirmModalShow', this.onConfirmModalShow );
	}

	onTcaUpdate( rules: any ) {
		let postData = Object.assign( {}, this.state.postData );
		postData.tca_rules = rules;
		this.setState( { postData: postData } );
	}

	render() {
		return (
			<Fragment>
				{ this.props.children }
				{ this.state.confirmModalShow == true &&
					<ConfirmModal
						key={ this.state.confirmModalData.key }
						title={ this.state.confirmModalData.title }
						subtitle={ this.state.confirmModalData.subtitle }
						onRequestClose={ this.onConfirmModalRequestClose }
						onChoice={ this.onConfirmModalChoice }
					/>
				}
				{ this.props.tcaEnabled == true &&
					<TcaRuleEditor
						rules={ this.state.tcaRules }
						onUpdate={ this.onTcaUpdate }
					/>
				}
				<input type="hidden" name="tokenly_data" value={ JSON.stringify( this.state.postData as any ) } />
			</Fragment>
		)
	}
}
